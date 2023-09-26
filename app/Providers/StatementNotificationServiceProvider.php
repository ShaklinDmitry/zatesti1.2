<?php

namespace App\Providers;

use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;
use App\Modules\Notifications\Infrastructure\Notifications\TelegramNotificationSystem;
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
        $this->app->bind(StatementNotificationSystemInterface::class, TelegramNotificationSystem::class);
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
