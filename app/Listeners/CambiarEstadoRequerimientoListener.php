<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class CambiarEstadoRequerimientoListener {

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
     * @param  EstadosRequerimiento  $event
     * @return void
     */
    public function handle(\App\Events\EstadosRequerimientoEvent $event) {
        $estado = (($event->campos_data->estado == 47) ? config('conf_aplicacion.C_EN_PROCESO_SELECCION') : $event->campos_data->estado);

        $req = \App\Models\EstadosRequerimientos::where("req_id", $event->campos_data->requerimiento_id)
                ->where("estado", $estado)
                ->get();
        
        if ($req->count() == 0) {
            $estadoObj = new \App\Models\EstadosRequerimientos();
            $estadoObj->estado = $estado;
            $estadoObj->user_gestion = $event->campos_data->user_id;
            $estadoObj->req_id = $event->campos_data->requerimiento_id;
            $estadoObj->save();
        }
    }

}
