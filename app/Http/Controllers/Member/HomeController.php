<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\CrudController;
use App\Models\User;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class HomeController extends MemberController
{
    protected $basePath = 'member.home'; 

    protected function postRender(&$data)
    {
        $auth_user = Auth::user();

        $user = new User();
        $user->forceFill(['id' => $auth_user->id]);

        $data['permissions'] = collect($user->getPermissionsViaRoles())->map(fn ($data) => $data['name']);
        $data['user'] = $user->getRow($auth_user->id);
    }

    public function index(Request $request)
    { 
        return $this->render('index', [
            'title' => 'Home',
            'theme' => 'bg-gray-100'
        ]);
    }

    public function ping(Request $request){
        User::updatePing(Auth::id()); 
    }
}
