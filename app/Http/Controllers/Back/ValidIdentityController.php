<?php

namespace App\Http\Controllers\Back;

use App\Libraries\NJYImage\Driver\BBMP;
use App\Libraries\NJYImage\Driver\Generic;
use App\Libraries\NJYImage\Driver\RSAP;
use App\Libraries\NJYImage\ImageHelper;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Switch_;

class ValidIdentityController extends BackController
{
    protected $basePath = 'back.valid_identity';
    protected $model = 'App\Models\ValidIdentity';
    protected $title = 'Review';
    protected $title_update = 'Update';
    protected $title_create = 'Create';
    protected $title_show = 'Show';
    protected $rules_create = [];
    protected $rules_update = [
        "image" => "nullable|image",
        "no"    => "required|string",
        "type"  => "required|string"
    ];

    protected $version = "6";

    protected function preUpdate(Request $request, &$row_update, string $id)
    {
        if (empty($request->file("image"))) return;
        $image_path = $request->file("image")->store('public');
        $row_update["image"] = $image_path;
    }

    //instead of fetching the id for valid_ids, it'll 
    //be fetching user_id to get the valid_ids associated with it
    public function show(string $user_id, Request $request)
    {
        return $this->render('show', [
            'title' => $this->title_show,
            'id' => $user_id,
            'data' => app($this->model)->getRowByUserId($user_id)
        ]);
    }

    public function showID(string $user_id, Request $request)
    {
        $row = app(User::class)->getRow($user_id); 

        if (empty($row) || $row['state'] != 'approved') {
            abort(404);
        }

        $time = strtotime($row['updated_at']);
        $info_time = strtotime($row['info_updated_at']);
        $file_name = "{$time}-{$info_time}-{$this->version}";
        $file_path = "draft/{$user_id}/$file_name.png";
        $profile = str_replace("storage/", "", "app{$row['profile']}");
        $storage_path = storage_path("app/{$file_path}");

        if (file_exists($storage_path) && !env('ID_TEST',false)) {
            return response()->file($storage_path);
        } 

        $sub_group = strtoupper($row['sub_group_name']);
        if (!empty($sub_group)) $sub_group .= "-";
        // $order = str_pad($row['order'], 8, '0', STR_PAD_LEFT);
        $order = strtoupper(substr($user_id,0,4));
        $order = "{$sub_group}{$order}";

        $driver = null;
        switch (env('ID_FORMAT')) {
            case "BBMP":
                $driver = new BBMP();
                break;
            case "RSAP":
                $driver = new RSAP();
                break;
            default:
                $driver = new Generic();
                break;
        }

        $helper = new ImageHelper($driver);

        $path = $helper->generateImage([
            "name" => $row['name'],
            "user_id" => $user_id,
            "timestamp" => $file_name,
            "profile_img" => storage_path($profile),
            "sub_group_text" => $order,
            "user" => $row
        ]);

        return response()->file($storage_path);
    }
}
