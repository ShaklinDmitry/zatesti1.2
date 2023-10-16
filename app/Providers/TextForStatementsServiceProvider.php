<?php

namespace App\Providers;

use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Application\Services\TextForStatementsServiceInterface;
use Illuminate\Support\ServiceProvider;

class TextForStatementsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TextForStatementsServiceInterface::class, function ($app) {
            $textForStatementsService = new TextForStatementsService();
            return $textForStatementsService;
        });
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
