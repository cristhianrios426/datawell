<?php

namespace App\Providers;
use App\Validator;
use App\ORM\Location;
use App\ORM\User;
use App\ORM\Well;
use App\ORM\Service;
use App\ORM\Revision;
use App\ORM\Attachment;
use App\ORM\BaseModel;
use App\ORM\Observer\LocationObserver;
use App\ORM\Observer\PersonObserver;
use Illuminate\Support\ServiceProvider;
use DB;

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

            $v =  new Validator($translator, $data, $rules,$messages, $customAttributes);
            $v->addReplacer('any_parameter', function($message, $attribute, $rule, $parameters){
                $preg_match_all = [];
                preg_match_all("/(:parameter\.)([0-9]+)/", $message, $preg_match_all);
                dd($preg_match_all);
                $matches = $preg_match_all[0];
                $indexes = $preg_match_all[2];
                if(count($matches) > 0){
                    foreach ($matches as $key => $match) {
                        if(isset($parameters[$indexes[$key]])){
                            $message =  str_replace($match, $parameters[$indexes[$key]], $message);      
                        }
                    }
                    return $message;
                }else{
                    return $message;
                }
            });
            return $v;

        });
        Location::observe(LocationObserver::class);
        BaseModel::observe(PersonObserver::class);
        User::observe(PersonObserver::class);
        Revision::observe(PersonObserver::class);
        Attachment::observe(PersonObserver::class);
        Well::observe(PersonObserver::class);
        Service::observe(PersonObserver::class);
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

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
