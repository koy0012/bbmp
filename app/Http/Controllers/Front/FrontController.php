<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController; 

class FrontController extends BaseController
{
    protected $baseLayout = "include.layout";
    protected $basePath = 'auth';

    public function privacy(){
        $this->render('landing',[
            "title" => 'Terms & Privacy'
        ]);
    }
}