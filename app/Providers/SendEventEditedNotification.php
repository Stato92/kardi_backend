<?php

namespace App\Providers;

use App\Providers\EventEdited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEventEditedNotification
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
     * @param  EventEdited  $event
     * @return void
     */
    public function handle(EventEdited $event)
    {
        //
    }
}
