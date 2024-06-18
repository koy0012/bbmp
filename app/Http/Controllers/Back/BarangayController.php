<?php

namespace App\Http\Controllers\Back;

use App\Models\ActivityLog;
use App\Models\Barangay;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;

class BarangayController extends BackController
{
    protected $basePath = 'back.barangay';
    protected $model = Barangay::class;
    protected $title = 'Barangay';
    protected $title_update = 'Update Barangay';
    protected $title_create = 'Create Barangay';
    protected $title_manage = 'Manage Barangay';
    protected $title_show = 'Barangays';

    protected $rules_create = "";

    public function publicList(Request $request)
    {
        $request->validate([
            'config.municipal_id' => 'required|alpha_dash|max:255'
        ]);

        $request = $request->merge([
            'config' => [
                'list' => 'public',
                'municipal_id' => $request->get('config')['municipal_id']
            ]
        ]);

        return parent::list($request);
    }

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

    public function show(string $municipal_id, Request $request)
    {
        $data = app(Municipal::class)->getRow($municipal_id);

        if (empty($data)) abort(404);

        return $this->render('index', [
            'title' => $this->title_show,
            'id' => $municipal_id,
            'data' => $data
        ]);
    }
 
    public function manage(string $barangay_id, Request $request)
    {
        $data = app(Barangay::class)->getRow($barangay_id);
        if (empty($data)) {
            abort(404);
        }

        $head = app(User::class)->getRow($data['head_user_id']);

        return $this->render('manage', [
            'title' => $this->title_manage,
            'id' => $barangay_id,
            'logs' => ActivityLog::recent('', where_array: [
                'ref_one' => $barangay_id
            ]),
            'data' => $data,
            'head' => $head,
            'theme' => 'bg-gray-100'
        ]);
    }
}
