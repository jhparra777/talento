<?php

namespace App\Providers;

//Redes Sociales
use Auth;
use app\Extensions\RiakUserProvider;
//use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //Redes Sociales
         Auth::extend('riak', function($app){
            return new RiakUserProvider($app['riak.connection']);
        });
    }

    public function register(){
        
    }

}
