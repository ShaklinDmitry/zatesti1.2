<?php

namespace App\Providers;

use App\Models\Text;
use App\Services\TextService;
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
        $this->app->bind(TextService::class, function ($app) {
            $textForStatements = new Text();

            return new TextService($textForStatements);
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
