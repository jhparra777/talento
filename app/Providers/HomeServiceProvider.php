<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HomeServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        // Using class based composers...

        view()->composer(
            '*', 'App\Http\ViewComposer\HomeComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
