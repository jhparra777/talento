<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CallingEvent extends Event
{
    use SerializesModels;
    public $message;
    public $destino;
    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $destino)
    {
        $this->message = $message;
        $this->destino =  $destino;
        
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
