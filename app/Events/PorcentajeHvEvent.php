<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\datosBasicos;

class PorcentajeHvEvent extends Event
{
    use SerializesModels;
    public  $candidato ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DatosBasicos $candidato)
    {
        $this->candidato = $candidato;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
