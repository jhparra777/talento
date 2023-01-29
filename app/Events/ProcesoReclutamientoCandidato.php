<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\ReqCandidato;

class ProcesoReclutamientoCandidato extends Event {

    use SerializesModels;

    public $campos_data;
    public $estado;
    public $candidato_req;
    public $candidato;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($campos = array(), $estado, $candidato_req) {
        $this->candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")->where("requerimiento_cantidato.id", $candidato_req)
                ->select("requerimiento_cantidato.*")
                ->first();
        $this->campos_data = $campos +
                [ 'requerimiento_id' => $this->candidato->requerimiento_id,
                    'candidato_id' => $this->candidato->candidato_id,
                    'estado' => $estado,
                    'fecha_inicio' => date("Y-m-d H:i:s")];
        $this->estado = $estado;
        $this->candidato_req = $candidato_req;
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
