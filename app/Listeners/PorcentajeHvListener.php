<?php

namespace App\Listeners;

use App\Events\PorcentajeHvEvent;
use App\Models\DatosBasicos;
use App\Models\Sitio;

class PorcentajeHvListener
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
    public function handle(PorcentajeHvEvent $event)
    {
            //$campos=json_decode($event->candidato->campos_porcentaje_hv);
        $sitio=Sitio::first();
        $campos=(array)json_decode($sitio->campos_porcentaje_hv);
        $total=count($campos);
        $cantidad=0;
        foreach($campos as $key=>$val){
            if($event->candidato->$key!=null && $event->candidato->$key!=""){
                $cantidad++;
            }
        }
        $event->candidato->datos_basicos_count=round($cantidad*100/$total);
        $event->candidato->save();
        
    }

}
