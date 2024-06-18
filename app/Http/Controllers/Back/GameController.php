<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Models\Municipal;
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

class GameController extends BackController
{
    protected $basePath = 'back.games';
    protected $model = 'App\Models\Municipal';
    protected $title = 'Municipal';
    protected $title_update = 'Update Games';
    protected $title_create = 'Create Games';
    protected $title_manage = 'Manage Games';
    protected $title_show = 'Games';

    protected $rules_create = ""; 
    
    public function show(string $region_id, Request $request)
    {  
        $data = app(Region::class)->getRow($region_id);
        if(empty($data)){
            abort(404);
        }  

        return $this->render('show', [
            'title' => $this->title_show,
            'id' => $region_id,
            'data' => $data
        ]);
    } 

    public function province(string $province_id)
    {  
        $data = app(Province::class)->getRow($province_id);
        if(empty($data)){
            abort(404);
        }  

        return $this->render('show', [
            'title' => $this->title_show,
            'id' => $data['region_id'],
            'province_id' => $province_id,
            'data' => $data
        ]);
    } 

    public function getActiveUsers(Request $request){
        $request->validate([
            "province_id" => "nullable|alpha_dash",
            "municipal_id" => "nullable|alpha_dash",
            "groups.*" => "nullable|alpha_dash"
        ]);

        $province = $request->get("province_id");
        $municipal = $request->get("municipal_id"); 
        $groups = $request->get("groups"); 

        $data = User::GetAllActive([
            "province_id" => $province,
            "municipal_id" => $municipal,
            "groups" => $groups
        ]); 

        return response()->json($data);
    } 
}
