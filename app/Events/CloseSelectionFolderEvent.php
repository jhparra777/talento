<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\ReqCandidato;

class CloseSelectionFolderEvent extends Event
{
    use SerializesModels;
    public  $req_can;
    public  $folder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReqCandidato $req_can,$folder=1)
    {
        $this->req_can = $req_can;
        $this->folder = $folder;
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
