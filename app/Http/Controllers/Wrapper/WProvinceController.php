<?php

namespace App\Http\Controllers\Wrapper;

use App\Http\Controllers\Back\MunicipalController;
use App\Http\Controllers\Back\ProvinceController;
use App\Http\Controllers\Back\RegionController;
use App\Rules\MunicipalOwnership;
use App\Rules\RegionOwnership;
use Illuminate\Http\Request; 

class WProvinceController extends ProvinceController
{   
    public function manage(string $region_id, Request $request){ 
        
        $request->merge([
            'region_id'=> $region_id
        ]);

        $request->validate([
            "region_id" => [new RegionOwnership()]
        ]);

        return parent::manage($region_id, $request);
    } 
}
