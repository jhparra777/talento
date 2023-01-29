<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\EstadosRequerimientos;

class EstadosRequerimientoEvent extends Event {

    use SerializesModels;

    public $campos_data;
    public $model_estados;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($obj) {
        $this->campos_data = $obj;
        $estado = (($this->campos_data->estado == 41) ? config('conf_aplicacion.C_EN_PROCESO_SELECCION') : $this->campos_data->estado);
        $this->model_estados = \App\Models\EstadosRequerimientos::where("req_id", $this->campos_data->requerimiento_id)
                ->where("estado", $estado)
                ->get();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }

}
