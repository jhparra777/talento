<?php

namespace App\Handlers\Events;

use App\Events\AuditoriaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuditoriaListener
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuditoriaEvent  $event
     * @return void
     */
    public function handle(AuditoriaEvent $event)
    {
        //
    }
}
