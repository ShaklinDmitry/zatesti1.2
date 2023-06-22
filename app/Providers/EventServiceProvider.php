<?php

namespace App\Providers;

use App\Events\SendUserResponse;
use App\Listeners\MakeStatementsFromText;
use App\Listeners\MarkStatementHasBeenSent;
use App\Listeners\SaveBestStatements;
use App\Listeners\SaveTextForStatements;
use App\Listeners\SaveUserResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotificationSent::class => [
            MarkStatementHasBeenSent::class
        ],
        SendUserResponse::class => [
            SaveUserResponse::class,
            SaveBestStatements::class,
            SaveTextForStatements::class,
            MakeStatementsFromText::class
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
