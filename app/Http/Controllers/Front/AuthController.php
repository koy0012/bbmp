<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Termwind\Components\BreakLine;

class AuthController extends FrontController
{

    //TODO: security hacker can replicate this putting the user verifying it at risk
    public function verify($user_id, Request $request)
    {
        $user = User::where('id', $user_id)->first();

        if (!empty($user) && strcmp($user['state'] ?? '', 'approved') == 0) {
            //success
            return $this->render('verify', [
                'title' => 'Verification',
                'verified' => true,
                'name' => $this->obsecure($user['name'])
            ]);
        } else {

            //fail
            return $this->render('verify', [
                'title' => 'Verification',
                'verified' => false,
                'name' => isset($user['name']) ? $this->obsecure($user['name']) : 'not registered'
            ]);
        }
    }

    protected function obsecure(string $name)
    {
        $n = explode(" ", $name);
        foreach ($n as &$row) {
            if (strlen($row) == 1) continue;
            if (preg_match('/(.)(.*)(.)/', $row, $matches)) {
                $row = $matches[1] . str_repeat("*", strlen($matches[2])) . ($matches[3] ?? '');
            }
        }

        return implode(" ", $n);
    }

    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return $this->render('login', [
            'title' => $this->title,
            'theme' => 'login-theme'
        ]);
    }

    public function logout(Request $request)
    {
        if(!empty(Auth::id())){
            ActivityLog::log(Auth::id(), 'You Logged Logout', 'user_logout');
        } 

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        return $this->render('forgot', [
            'title' => "Forgot Password",
            'theme' => 'forgot-theme'
        ]);
    }

    public function requestReset(Request $request)
    {
        $request->validate(
            ["username" => "required|string|max:255|exists:users,username"],
            [
                "username.exists" => 'username does not exists'
            ]
        );

        $status = Password::sendResetLink($request->only('username'));

        if ($status ===  Password::RESET_LINK_SENT) {
            return response()->json([
                "success" => true,
                "message" => 'Password request sent'
            ]);
        } else {

            $msg = "";

            switch ($status) {
                case "passwords.throttled":
                    $password_time = config('auth.passwords.users.throttle');
                    $time = ($password_time / 60) . " mins";
                    $msg = "You may request again after {$time}.";
                    break;
                default:
                    $msg = "Failed to request password";
                    break;
            }

            return response()->json([
                "errors" => [
                    "username" => $msg
                ],
                "message" => $msg
            ]);
        }
    }

    public function resetForm(string $token, Request $request)
    {
        $request->validate(
            ["username" => "required|string|max:255|exists:users,username"],
            [
                "username.exists" => 'Username does not exists'
            ]
        );

        $user = User::where('username', $request->get('username'))->first();

        return $this->render('reset', [
            'title' => "Reset Password",
            'theme' => 'reset-theme',
            'token' => $token,
            'username' => $request->get('username'),
            'show_login_url' => $user['role'] != 'member'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'username' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('username', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        switch ($status) {
            case Password::PASSWORD_RESET:
                return response()->json([
                    'success' => true,
                    'message' => $status
                ]);
            case 'passwords.token':
                return response()->json([
                    'success' => false,
                    'message' => 'Token has expired or invalid'
                ], 422);
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to process your request'
                ], 422);
        }
    }

    
    public function login_konnek(Request $request)
    {
        $client = new Client();

        $response = $client->post('https://konnek.social/api/auth', [
            'form_params' => [
                'username' => $request->post("username"),
                'password' => $request->post("password"),
                'server_key' => '4bf431d8b30268ded27eaf0c83d191fe'
            ]
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if (isset($responseBody['access_token'])) {
            $token = $responseBody['access_token'];
        }

       return $token;

    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'nullable|string',
            'password' => 'required'
        ]);
        

        if (Auth::attempt($credentials)) {
            $user = User::where('username', $request->post('username'))->first();
            ActivityLog::log($user['id'], 'You Logged In', 'user_login');

            if ($user['state'] != 'approved') {
                return response()->json([
                    "success" => false,
                    'errors' => [
                        'username' => 'Your account is not yet reviewed'
                    ]
                ]);
            }

            $access_token = $this->login_konnek($request);

            if ($user['role'] == 'member') {
                return response()->json([
                    "route" => 'member',
                    "success" => true,
                    "token" => $access_token
                ]);
            }

            $request->session()->regenerate();

            return response()->json([
                "success" => true
            ]);
        }

        return response()->json([
            "success" => false,
            "errors" => [
                "username" => "invalid credentials"
            ]
        ]);
    }
}
