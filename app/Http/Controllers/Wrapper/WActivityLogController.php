<?php

namespace App\Http\Controllers\Wrapper;

use App\Http\Controllers\Back\ActivityLogController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\UserInfoController;
use App\Models\Municipal;
use App\Models\User;
use App\Rules\RoleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WActivityLogController extends ActivityLogController
{ 
    public function list(Request $request)
    {
        $request->validate([
            'config.user_id' => 'required|alpha_dash|max:255'
        ]);

        $user_id = $request->input('config.user_id');

        $this->hasErrors($user_id, $request);

        return parent::list($request);
    }

    public function show(string $user_id, Request $request)
    {
        $this->hasErrors($user_id, $request);

        return parent::show($user_id, $request);
    }

    private function hasErrors($user_id, Request $request)
    {
        /** @var User $self */
        $self = Auth::user();
        $target = User::find($user_id);

        $request->merge([
            'role' => $target->id
        ]); 

        try {
            $request->validate([
                'role' => [new RoleOrder()]
            ]);
        }catch(ValidationException $ex){
            abort(403,$ex->getMessage());
        }

        if (empty($target)) return abort(404);
        if ($self->id != $user_id && !$self->hasAnyRole(['national', 'municipal'])) {
            abort(403);
        }
        if ($self->hasRole('municipal') && $target['municipal_id'] != $self->municipal_id) {
            abort(403, 'Member does not reside in your authority.');
        }
    }
}
