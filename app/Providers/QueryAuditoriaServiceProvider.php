<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\QueryAuditoria;

class QueryAuditoriaServiceProvider extends ServiceProvider
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
         $this->app->singleton('query_auditoria', function ($app) {
            return new QueryAuditoria();
        });
    }
}
