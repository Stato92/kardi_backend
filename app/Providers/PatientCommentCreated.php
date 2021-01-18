<?php

namespace App\Providers;

use App\PatientComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientCommentCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $patientComment;


    /**
     * Create a new event instance.
     *
     * @param PatientComment $patientComment
     */
    public function __construct(PatientComment $patientComment)
    {
        $this->patientComment = $patientComment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('patients.'.$this->patientComment->patient_id);
    }
    public function broadcastAs()
    {
        return 'comment.created';
    }
}
