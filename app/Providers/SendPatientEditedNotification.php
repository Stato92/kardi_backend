<?php

namespace App\Providers;

use App\Providers\PatientEdited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPatientEditedNotification
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
     * @param  PatientEdited  $event
     * @return void
     */
    public function handle(PatientEdited $event)
    {
        //
    }
}
