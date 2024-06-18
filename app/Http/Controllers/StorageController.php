<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\CrudController;  

class StorageController extends CrudController
{
     
    public function storage($dir,$path){ 
        $path = storage_path("app/$dir/$path");

        // if(!file_exists($path)){
        //     abort(404);
        // } 

        return response()->file($path);
    }
 
}