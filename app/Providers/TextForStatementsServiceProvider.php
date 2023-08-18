<?php

namespace App\Providers;

use App\Models\TextForStatementsModel;
use App\Services\TextForStatementsService;
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
        $this->app->bind(TextForStatementsService::class, function ($app) {
            $textForStatements = new TextForStatementsModel();

            return new TextForStatementsService($textForStatements);
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
