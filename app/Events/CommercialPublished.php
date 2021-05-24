<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommercialPublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $commercial;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return void
     */
    public function __construct($commercial)
    {
        $this->commercial = $commercial;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
