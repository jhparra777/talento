<?php

namespace App\Listeners;

use App\Events\ProcesoReclutamientoCandidato;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ReqCandidato;
use App\Models\RegistroProceso;

class RegistroProcesoListener {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProcesoReclutamientoCandidato  $event
     * @return void
     */
    public function handle(ProcesoReclutamientoCandidato $event) {

        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill($event->campos_data);
        $nuevo_proceso->save();
        
    }

}
