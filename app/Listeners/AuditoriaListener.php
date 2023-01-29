<?php

namespace App\Listeners;

use App\Events\AuditoriaEvent;
use App\Models\Auditoria;

class AuditoriaListener
{

    /**
     * Create the event listener.
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

        $guardaAuditoria = new Auditoria();
        $guardaAuditoria = $event->model_auditoria;
        $guardaAuditoria->save();
    }

}
