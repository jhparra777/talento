<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\FuncionesGlobales;


class GlobalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
          $this->app->singleton('FuncionesGlobales', function ($app) {
            return new FuncionesGlobales();
        });
    }
}
