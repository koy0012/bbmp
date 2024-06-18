<?php

namespace App\Http\Controllers\Wrapper;

use App\Http\Controllers\Back\UserController;
use App\Models\Municipal;
use App\Models\User;
use App\Rules\RoleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WUserController extends UserController
{

    public function list(Request $request)
    {
        $user = Auth::user();

        $config = $request->get('config');

        if ($user->hasRole('municipal')) {
            if (empty($config['municipal_id'])) abort(404);
            if ($config['municipal_id'] != $user->municipal_id) abort(403, "You don't have access to this municipal");
        } else if ($user->hasRole('regional')) {
            $request->validate([
                'config.role' => 'required|in:municipal,regional'
            ]);

            if (!empty($config['municipal_id'])) {
                $ownership = Municipal::where('id', $config['municipal_id'])->first();
                if (empty($ownership) || $ownership['region_id'] != $user->regional_id) {
                    abort(403);
                }
            }else {
                if ($config['region_id'] != $user->regional_id) abort(403, "You don't have access to this region");
            }
        }

        return parent::list($request);
    }

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
