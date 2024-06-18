<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProvinceController extends BackController
{
    protected $basePath = 'back.province';
    protected $model = Province::class;
    protected $title = 'Provinces';
    protected $title_update = 'Update Province';
    protected $title_create = 'Create Province';
    protected $title_manage = 'Manage Province';
    protected $title_show = 'Provinces';
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

        $request->validate([
            'head_user_id' => 'nullable|unique:provinces,head_user_id'
        ], [
            'head_user_id.unique' => "Member is already a provincial head."
        ]);

        $request->validate([
            'head_user_id' => 'nullable|unique:barangays,head_user_id'
        ], [
            'head_user_id.unique' => "Member is already a barangay head."
        ]);
    }

    //todo apply security on public list
    public function publicList(Request $request)
    { 

        $request = $request->merge([
            'config' => [
                'list' => 'public'
            ]
        ]);

        return parent::list($request);
    }

    public function show(string $region_id, Request $request)
    {
        $data = app($this->model)->getRow($region_id, 'provinces.region_id');

        if (empty($data)) abort(404);

        return $this->render('index', [
            'title' => $this->title_show,
            'id' => $region_id,
            'data' => $data
        ]);
    }
 
    public function manage(string $province_id, Request $request)
    {
        $data = app(Province::class)->getRow($province_id);
        if (empty($data)) {
            abort(404);
        }

        $head = app(User::class)->getRow($data['head_user_id']);

        return $this->render('manage', [
            'title' => $this->title_manage,
            'id' => $data['region_id'],
            'logs' => ActivityLog::recent('', where_array: [
                'ref_one' => $province_id
            ]),
            'province_id' => $data['id'],
            'data' => $data,
            'head' => $head,
            'theme' => 'bg-gray-100'
        ]);
    }
}
