<?php

namespace App\Providers;

use App\Patient;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $patient;

    /**
     * Create a new event instance.
     *
     * @param Patient $patient
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('patients');
    }
    public function broadcastAs()
    {
        return 'patient.created';
    }
}
