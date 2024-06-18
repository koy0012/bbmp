<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BaseController extends Controller
{
    protected $baseLayout = 'back.include.layout';
    protected $basePath = '';
    protected $title = ''; 
    
    protected function render($path,$data){ 
        $data['nav'] = $data['nav'] ?? $this->baseLayout;
        $data['title'] = $data['title'] ?? "???";
        $data['basePath'] = $data['basePath'] ?? $this->basePath; 
        $data['fullPath'] = "{$data['basePath']}.{$path}";
        $data['appName']  = env('APP_NAME');
        $data['baseUrl'] = url('/');
        $data['addons'] = $data['addons'] ?? [];
        $data['theme'] = $data['theme'] ?? "";

        $this->postRender($data);

        return view($data['nav'],$data);
    } 

    //overridable
    protected function postRender(&$data){ 

    }
}


