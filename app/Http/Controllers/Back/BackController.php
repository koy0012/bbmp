<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Models\Group;
use App\Models\Municipal;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;

class BackController extends CrudController
{
    protected $baseLayout = "back.include.layout";
    protected $basePath = 'back';

    protected function postRender(&$data){  
        $user = Auth::user();
        $info = UserInfo::where('user_id',$user->id)->first();

        $municipal = app(Municipal::class)->getRow($user->municipal_id); 
        
        $sub_group = Group::find($info['sub_group']); 

        $data['encoder'] = [
            "name" => $user->name,
            "email" => $user->email,
            "id" => $user->id,
            "role" => $user->role,
            "profile" => $user->profile,
            "region_id" => $user->regional_id,
            "municipal_id" => $user->municipal_id,
            'municipal' => $municipal['name'] ?? '',
            'municipal_details' => $municipal,
            'sub_group' => $sub_group
        ];   

        $user = new User();
        $user->forceFill($data['encoder']); 
        $data['permissions'] = collect($user->getPermissionsViaRoles())->map(fn ($data) => $data['name']);
    }
}