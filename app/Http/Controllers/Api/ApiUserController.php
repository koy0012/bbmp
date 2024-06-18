<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ApiUserController extends ApiController
{
    protected $baseLayout = "";
    protected $basePath = '';

    protected function postRender(&$data)
    {
        $data['encoder'] = [
            "name" => Auth::user()->name,
            "id" => Auth::user()->id
        ];
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        unset($credentials['device_name']);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken($request->device_name)->plainTextToken;
            $info = app(User::class)->getRow($user['id']);

            return response()->json([
                "success" => true,
                'token' => $token,
                'data' => $info
            ]);
        }

        return response()->json([
            "success" => false,
            "errors" => [
                "email" => "invalid credentials"
            ]
        ]);
    }

    public function logout(Request $request)
    { 
        $token = explode("|", $request->bearerToken());


        if (!is_numeric($token[0]) || count($token) != 2) {
            return response()->json([
                'success' => false,
                'message' => 'invalid token'
            ]);
        }  

        
        $ownership = PersonalAccessToken::findToken($token[1]); 

        if(empty($ownership)){
            return response()->json([
                'success' => false,
                'message' => 'invalid token'
            ]);
        } 
        
        $res = $request->user()->tokens()->where('id', $ownership->id)->delete();  

        return response()->json([
            'success' => $res > 0
        ]);
    }
}
