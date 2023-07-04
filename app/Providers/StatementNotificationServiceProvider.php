<?php

namespace App\Providers;

use App\Domains\Notifications\Interfaces\StatementNotification;
use App\Domains\Notifications\TelegramNotification;
use Illuminate\Support\ServiceProvider;

class StatementNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StatementNotification::class, TelegramNotification::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
