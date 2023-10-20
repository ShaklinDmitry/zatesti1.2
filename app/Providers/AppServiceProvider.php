<?php

namespace App\Providers;

use App\Models\UserResponse;
use App\Modules\Statements\Application\UseCases\CreateStatementCommand;
use App\Modules\Statements\Application\UseCases\CreateStatementCommandInterface;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommand;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommandInterface;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MakeStatementsFromTextCommandInterface::class, function ($app) {

            $textForStatementsRepository = new TextForStatementsRepository();
            $сreateStatementCommand = new CreateStatementCommand();

            return new MakeStatementsFromTextCommand($textForStatementsRepository, $сreateStatementCommand);
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
