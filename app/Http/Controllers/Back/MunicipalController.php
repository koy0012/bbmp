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

class MunicipalController extends BackController
{
    protected $basePath = 'back.municipal';
    protected $model = 'App\Models\Municipal';
    protected $title = 'Municipal';
    protected $title_update = 'Update Municipal';
    protected $title_create = 'Create Municipal';
    protected $title_manage = 'Manage Municipal';
    protected $title_show = 'Municipals';

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

    protected function preUpdate(Request $request, &$row_update, string $id){ 
        $request->validate([
            'head_user_id' => 'nullable|unique:regions,head_user_id'
        ],[
            'head_user_id.unique' => "Member is already a regional head."
        ]);

        $request->validate([
            'head_user_id' => 'nullable|unique:municipals,head_user_id|exists:users,id'
        ],[
            'head_user_id.unique' => "Member is already a municipal head."
        ]);

        if(isset($row_update['head_user_id'])){   
            Municipal::isMunicipalHead($row_update['head_user_id']); 
        }
    }

    public function publicList(Request $request)
    {
        $request->validate([
            'config.region_id' => 'required|alpha_dash|max:255'
        ]);

       

        return parent::list($request);
    }
 
    public function manage(string $municipal_id, Request $request){ 
        $data = app(Municipal::class)->getRow($municipal_id); 
        if(empty($data)){
            abort(404);
        } 

        $head = app(User::class)->getRow($data['head_user_id']);

        return $this->render('manage', [
            'title' => $this->title_manage,
            'id' => $municipal_id,
            'data' => $data,
            'head' => $head,
            'theme' => 'bg-gray-100'
        ]);
    } 
}
