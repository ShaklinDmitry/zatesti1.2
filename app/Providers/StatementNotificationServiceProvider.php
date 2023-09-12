<?php

namespace App\Providers;

use App\Classes\Notifications\Interfaces\StatementNotificationSystem;
use App\Classes\Notifications\TelegramNotificationSystem;
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
        $this->app->bind(StatementNotificationSystem::class, TelegramNotificationSystem::class);
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
