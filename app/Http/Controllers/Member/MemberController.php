<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController; 
use Illuminate\Support\Facades\Auth;

class MemberController extends BaseController
{
    protected $baseLayout = "member.include.layout";
    protected $basePath = 'member';

    protected function postRender(&$data){  
        $user = Auth::user();
        $data['user'] = $user;   
    }
}