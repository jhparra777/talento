<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Auditoria;

class AuditoriaEvent extends Event
{
    use SerializesModels;
    public  $model_auditoria ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Auditoria $auditoria)
    {
        $this->model_auditoria = $auditoria;
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
