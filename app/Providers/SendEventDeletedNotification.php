<?php

namespace App\Providers;

use App\Providers\EventDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEventDeletedNotification
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
     * @param  EventDeleted  $event
     * @return void
     */
    public function handle(EventDeleted $event)
    {
        //
    }
}
