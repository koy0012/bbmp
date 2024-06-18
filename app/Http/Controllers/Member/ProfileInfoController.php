<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Back\UserInfoController;
use App\Http\Controllers\Wrapper\WUserController;
use App\Http\Controllers\Wrapper\WUserInfoController;
use Illuminate\Support\Facades\Auth;

class ProfileInfoController extends WUserInfoController
{
    protected $baseLayout = 'member.include.layout';

    protected function postRender(&$data){  
        $user = Auth::user();
        $data['user'] = $user;   

        if($user->role != "member"){
            $data['nav'] = 'back.include.layout';
        }

        parent::postRender($data);
    }
}