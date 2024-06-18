<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GroupController extends BackController
{
    protected $basePath = 'back.group';
    protected $model = Group::class;
    protected $title = 'Sub Groups';
    protected $title_update = 'Update Sub-Group';
    protected $title_create = 'Create Sub-Group';
    protected $title_manage = 'Manage Sub-Group';
    protected $rules_create = "";

    protected function preUpdate(Request $request, &$row_update, string $id)
    {
       
    }

    public function store(Request $request)
    {
        $request->merge([
            "group_id" => "-",
            "group_type" => User::class
        ]);

        return parent::store($request);
    }


     
}
