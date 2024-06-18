<?php

namespace App\Http\Controllers\Back;

use App\Helpers\RateHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException; 

class UserInfoController extends BackController
{
    protected $basePath = 'back.user_info';
    protected $model = 'App\Models\UserInfo';
    protected $title = 'Member Info';
    protected $title_update = 'Update Member Info';
    protected $title_create = 'Create';
    protected $rules_create = [];
    protected $update_key_name = 'user_id'; 

    function preUpdate(Request $request, &$row_update, string $id)
    {
        RateHelper::AccountLimit("userinfo:{$id}",
        days:config('constants.rate_limit.user_info'));
    }

    public function edit(string $user_id)
    {
        $res = app($this->model)->getRowByUserId($user_id);

        $user = app(User::class)->getRow($user_id);

        if (empty($res)) abort(404);

        return $this->render('edit', [
            'title' => $this->title_update,
            'id' => $user_id,
            'user' => $user,
            'data' => app($this->model)->getRowByUserId($user_id)
        ]);
    }
}
