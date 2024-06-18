<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {  
        Schema::defaultStringLength(191);
        
        Validator::extend('alpha_space',function($attribute, $value, $paramters){
            return preg_match('/^[\pL\s\d\,\.\:\;\-\_\|\\/]+$/u', $value); 
        });

        Validator::extend('text_space',function($attribute, $value, $paramters){
            return preg_match('/^[\pL\s]+$/u', $value); 
        });
    }
}
