<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PatientCreated::class => [
        ],
        PatientEdited::class => [
        ],
        PatientDeleted::class => [
        ],
        StatusCreated::class => [
        ],
        StatusDeleted::class => [
        ],
        PatientCommentCreated::class => [],
        PatientCommentEdited::class => [],
        PatientCommentDeleted::class => [],
        UploadedFileCreated::class => [],
        UploadedFileDeleted::class => [],
        ChatMessageCreated::class => [],
        ChatMessageDeleted::class => [],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
