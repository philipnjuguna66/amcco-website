<?php

namespace App\Providers;

use App\Events\BlogCreatedEvent;
use App\Events\LeadCreatedEvent;
use App\Events\PageCreatedEvent;
use App\Listeners\BackupSuccessfulListener;
use App\Listeners\BlackListLoginAttempt;
use App\Listeners\LeadCreatedListener;
use App\Listeners\PageCreatedListener;
use App\Listeners\PostCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\Backup\Events\BackupWasSuccessful;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \Illuminate\Auth\Events\Lockout::class => [
            BlackListLoginAttempt::class,
        ],
        PageCreatedEvent::class => [
            PageCreatedListener::class,
        ],
        BlogCreatedEvent::class => [
            PostCreatedListener::class,
        ],
        LeadCreatedEvent::class => [
            LeadCreatedListener::class
        ],

        BackupWasSuccessful::class => [
            BackupSuccessfulListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
