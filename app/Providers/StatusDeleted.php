<?php

namespace App\Providers;

use App\Status;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $status;

    /**
     * Create a new event instance.
     *
     * @param Status $status
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [new PrivateChannel('statuses'),new PrivateChannel('patients.'.$this->status->patient_id)];
    }
    public function broadcastAs()
    {
        return 'status.deleted';
    }
}
