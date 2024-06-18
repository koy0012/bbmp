<?php

namespace App\Http\Controllers\Wrapper;

use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\UserInfoController;
use App\Models\Municipal;
use App\Models\User;
use App\Rules\RoleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WUserInfoController extends UserInfoController
{ 

    public function update(Request $request, string $id)
    {
        $user = Auth::user(); 

        if (strcmp($user->id,$id) != 0 && !$user->hasAnyRole('national|municipal')) {
            abort(403);
        } else if(strcmp($user->id,$id) != 0 && $user->hasRole('municipal')){
            $request->merge(['id' => $id]);
            $request->validate([
                'id' => [new RoleOrder()]
            ]);
        }

        return parent::update($request, $id);
    }
}
