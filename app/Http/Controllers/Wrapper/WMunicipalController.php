<?php

namespace App\Http\Controllers\Wrapper;

use App\Http\Controllers\Back\MunicipalController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Models\Municipal;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use App\Rules\MunicipalOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class WMunicipalController extends MunicipalController
{   
     
    public function manage(string $municipal_id, Request $request){ 
        
        $request->merge([
            'municipal_id'=> $municipal_id
        ]);

        $request->validate([
            "municipal_id" => [new MunicipalOwnership]
        ]);

        return parent::manage($municipal_id, $request);
    } 
}
