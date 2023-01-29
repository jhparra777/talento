<?php

namespace App\Listeners;

use App\Events\ProcesoReclutamientoCandidato;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcesoReclutamientoCandidato
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
     * @param  ProcesoReclutamientoCandidato  $event
     * @return void
     */
    public function handle(ProcesoReclutamientoCandidato $event)
    {

    }
}
