<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Requerimiento;

class PreperfiladosEvent extends Event
{
    use SerializesModels;
    public  $requerimiento ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Requerimiento $req)
    {
        $this->requerimiento = $req;
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
