<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Municipal;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class DashboardController extends BackController
{
    protected $basePath = 'back.dashboard';
    protected $title = 'Dashboard';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $report = [
            'user' => [ 
                'total' => User::count(),
                'verified' => UserInfo::whereNotNull('approved_by')->count(),
                'not_verified' => UserInfo::whereNull('approved_by')->count()
            ],
            'region' => [
                'total' => Region::count()
            ],
            'municipal' => [ 
                'total' => Municipal::count()
            ]
        ];

        return $this->render('index', [
            'theme' => 'bg-gray-100',
            'title' => $this->title,
            'report' => $report
        ]);
    }
}
