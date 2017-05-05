<?php

namespace App\Providers;
use App\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         \Validator::resolver(function($translator, $data,  $rules,
                                $messages = [], $customAttributes = []){

            return new Validator($translator, $data, $rules,$messages, $customAttributes);

         });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
