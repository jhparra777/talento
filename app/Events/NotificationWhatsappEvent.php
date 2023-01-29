<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationWhatsappEvent extends Event
{
    use SerializesModels;
    public $message;
    public $destino;
    public $type;
    public $nameTemplate;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $destino, $type = null, $nameTemplate = null, $data = array())
    {
        $this->message = $message;
        $this->destino =  $destino;
        $this->type = $type;
        $this->nameTemplate = $nameTemplate;
        $this->data = $data;
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
