<?php

namespace App\Providers;

use App\Classes\Text\Application\Events\TextForStatementsIsParsed;
use App\Classes\Text\Infrastructure\Listeners\MakeStatementsFromText;
use App\Classes\Text\Infrastructure\Listeners\SaveTextForStatements;
use App\Events\UserResponseSended;
use App\Listeners\MarkStatementHasBeenSent;
use App\Listeners\SaveBestStatements;
use App\Listeners\SaveUserResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationSent;

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
        UserResponseSended::class => [
            SaveUserResponse::class,
            SaveBestStatements::class,
            SaveTextForStatements::class,
            MakeStatementsFromText::class
        ],
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
