<?php

namespace App\Providers;

use App\Providers\PatientDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPatientDeletedNotification
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
     * @param  PatientDeleted  $event
     * @return void
     */
    public function handle(PatientDeleted $event)
    {
        //
    }
}
