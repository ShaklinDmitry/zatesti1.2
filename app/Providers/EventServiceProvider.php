<?php

namespace App\Providers;

use App\Events\UserResponseSended;
use App\Listeners\SaveUserResponse;
use App\Modules\BestStatements\Infrastructure\Listeners\SaveBestStatements;
use App\Modules\Statements\Infrastructure\Listeners\MarkStatementHasBeenSent;
use App\Modules\Text\Application\Events\TextForStatementsIsParsed;
use App\Modules\Text\Infrastructure\Listeners\MakeStatementsFromText;
use App\Modules\Text\Infrastructure\Listeners\SaveTextForStatements;
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
//        UserResponseSended::class => [
//      //      SaveUserResponse::class,
//      //      SaveBestStatements::class,
//            SaveTextForStatements::class,
//            MakeStatementsFromText::class
//        ],
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
