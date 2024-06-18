<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GroupMemberController extends BackController
{
    protected $basePath = 'back.group_member';
    protected $model = GroupMember::class;
    protected $title = 'Sub-Group Members';
    protected $title_update = 'Update Sub-Group Members';
    protected $title_create = 'Create Sub-Group Members';
    protected $title_manage = 'Manage Sub-Group Members';
    protected $rules_create = "";

    protected function preUpdate(Request $request, &$row_update, string $id)
    {
       
    }

    
     
}
