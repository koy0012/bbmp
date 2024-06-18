<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\AcitivityLog;
use App\Models\ActivityLog;
use App\Models\Municipal;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends BackController
{
    protected $basePath = 'back.activity_log';
    protected $title = 'Acitivty Log';
    protected $model = ActivityLog::class;

    function show(string $user_id, Request $request)
    {
        $data = app(User::class)->getRow($user_id);

        if (empty($data)) abort(404);

        return $this->render('index', [
            'title' => $data['name'],
            'id' => $user_id,
            'data' => $data
        ]);
    }
}
