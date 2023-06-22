<?php

namespace App\Providers;

use App\Interfaces\StatementNotification;
use App\Notifications\TelegramNotification;
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
