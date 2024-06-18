<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Back\AccountController;
use App\Http\Controllers\Wrapper\WUserController;
use Illuminate\Support\Facades\Auth;

class ProfileAccountController extends AccountController
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