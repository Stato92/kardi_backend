<?php

namespace App\Providers;

use App\Providers\PatientCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPatientCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PatientCreated  $event
     * @return void
     */
    public function handle(PatientCreated $event)
    {
        //
    }
}
