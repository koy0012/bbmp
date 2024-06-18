<?php

namespace App\Http\Controllers\Wrapper;

use App\Http\Controllers\Back\BarangayController; 
use App\Rules\RegionOwnership;
use Illuminate\Http\Request; 

class WBarangayController extends BarangayController
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
