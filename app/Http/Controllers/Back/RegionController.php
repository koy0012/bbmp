<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RegionController extends BackController
{
    protected $basePath = 'back.region';
    protected $model = 'App\Models\Region';
    protected $title = 'Regions';
    protected $title_update = 'Update Region';
    protected $title_create = 'Create Region';
    protected $title_manage = 'Manage Region';
    protected $rules_create = "";

    protected function preUpdate(Request $request, &$row_update, string $id)
    {
        $request->validate([
            'head_user_id' => 'nullable|unique:regions,head_user_id'
        ], [
            'head_user_id.unique' => "Member is already a regional head."
        ]);

        $request->validate([
            'head_user_id' => 'nullable|unique:municipals,head_user_id|exists:users,id'
        ], [
            'head_user_id.unique' => "Member is already a municipal head."
        ]); 
    }

    public function publicList(Request $request)
    {  
        $request = $request->merge([
            'config' => [
                'list' => 'public'
            ]
        ]);

        return parent::list($request);
    }
      
    public function manage(string $region_id, Request $request)
    {
        $data = app(Region::class)->getRow($region_id);
        if (empty($data)) {
            abort(404);
        }

        $head = app(User::class)->getRow($data['head_user_id']);

        return $this->render('manage', [
            'title' => $this->title_manage,
            'id' => $region_id,
            'logs' => ActivityLog::recent('',where_array:[
                'ref_one' => $region_id
            ]),
            'data' => $data,
            'head' => $head,
            'theme' => 'bg-gray-100'
        ]);
    }
}
