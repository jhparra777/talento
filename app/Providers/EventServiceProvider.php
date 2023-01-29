<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ProcesoReclutamientoCandidato;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\EstadosRequerimientoEvent' => [
            'App\Listeners\CambiarEstadoRequerimientoListener',
        ],
         'App\Events\AuditoriaEvent' => [
            'App\Listeners\AuditoriaListener',
        ],
        'App\Events\PorcentajeHvEvent' => [
            'App\Listeners\PorcentajeHvListener',
        ],
        'App\Events\PreperfiladosEvent' => [
            'App\Listeners\PreperfiladosListener',
        ],
        'App\Events\NotificationWhatsappEvent' => [
            'App\Listeners\NotificationWhatsappListener',
        ],
        'App\Events\CloseSelectionFolderEvent' => [
            'App\Listeners\CloseSelectionFolderListener',
        ],
        'App\Events\NotificacionAplicacionVacanteEvent' => [
            'App\Listeners\NotificacionAplicacionVacanteListener'
        ],
        'App\Events\SmsEvent' => [
            'App\Listeners\SmsListener',
        ],
        'App\Events\CallingEvent' => [
            'App\Listeners\CallingListener',
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot() {/*DispatcherContract $events*/
        parent::boot();//$events

        //
        // Fired on each authentication attempt...
        Event::listen('auth.attempt', function ($credentials, $remember, $login) {
            //
        });

        // Fired on successful logins...
        Event::listen('auth.login', function ($user, $remember) {
            //
        });

        // Fired on logouts...
        Event::listen('auth.logout', function ($user) {
            //
        });

    }

}
