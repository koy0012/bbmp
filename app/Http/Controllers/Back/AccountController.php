<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Municipal;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends BackController
{
    protected $basePath = 'back.account';
    protected $title = 'Account';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {    
        $logs = ActivityLog::recent(Auth::id());

        return $this->render('index', [
            'theme' => 'bg-gray-100',
            'title' => $this->title,
            'logs' => $logs,
            'data' => app(User::class)->getRow(Auth::id()),
            'valid_ids' => app(ValidIdentity::class)->getRowByUserId(Auth::id())
        ]);
    }

    
}
