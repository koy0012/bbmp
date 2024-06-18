<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AccountController extends ApiController
{
    protected $model = User::class;

    public function verify(Request $request)
    {
        $request->validate([
            "id" => "required|string"
        ]); 

        $id = $request->get('id');
 
        $user = User::where('id',$id)->first();  

        if (!empty($user) && strcmp($user['state'] ?? '', 'approved') == 0) {
            return response()->json([
                "success" => true,
                "id" => $id,
                "name"  => $this->obsecure($user['name']),
                "message" => "Member Verified"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "id" => $id,
                "name"  => isset($user['name']) ? $this->obsecure($user['name']) : '' ,
                "message" => "Not Verified"
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

        return implode(" ",$n); 
    } 
}
