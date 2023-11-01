<?php

namespace App\Providers;

use App\Modules\StatementNotifications\Application\UseCases\SendNotificationsToUsersAtTimeCommand;
use App\Modules\StatementNotifications\Application\UseCases\SendNotificationsToUsersAtTimeCommandInterface;
use App\Modules\StatementNotifications\Domain\StatementNotificationInterface;
use App\Modules\StatementNotifications\Infrastructure\Notifications\TelegramNotification;
use App\Modules\Statements\Application\UseCases\CreateStatementCommand;
use App\Modules\Statements\Application\UseCases\GetStatementForSendingCommand;
use App\Modules\Statements\Application\UseCases\GetStatementForSendingCommandInterface;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleByTimeCommand;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleByTimeCommandInterface;
use App\Modules\StatementSendingSchedule\Infrastructure\Repositories\StatementSendingScheduleRepository;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommand;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommandInterface;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\User\Application\UseCases\UserNotifyCommand;
use App\Modules\User\Application\UseCases\UserNotifyCommandInterface;
use App\Modules\User\Domain\UserNotifyServiceInterface;
use App\Modules\User\Infrastructure\UserNotifyService;
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

        $this->app->bind(GetStatementSendingScheduleByTimeCommandInterface::class, function($app){
            $statementSendingScheduleRepository = new StatementSendingScheduleRepository();

            return new GetStatementSendingScheduleByTimeCommand($statementSendingScheduleRepository);
        });

        $this->app->bind(StatementNotificationInterface::class, function ($app){
            return new TelegramNotification();
        });

        $this->app->bind(UserNotifyServiceInterface::class, function($app){
            $statementNotification = $app->make(StatementNotificationInterface::class);

            return new UserNotifyService($statementNotification);
        });

        $this->app->bind(UserNotifyCommandInterface::class, function ($app){
            $userNotifyService = $app->make(UserNotifyServiceInterface::class);
            return new UserNotifyCommand($userNotifyService);
        });

        $this->app->bind(GetStatementForSendingCommandInterface::class, function($app){
            $statementRepository = new StatementRepository();
            return new GetStatementForSendingCommand($statementRepository);
        });

        $this->app->bind(SendNotificationsToUsersAtTimeCommandInterface::class, function($app){
            $getStatementSendingScheduleByTimeCommand = $app->make(GetStatementSendingScheduleByTimeCommandInterface::class);
            $userNotifyCommand = $app->make(UserNotifyCommandInterface::class);
            $getStatementForSendingCommand = $app->make(GetStatementForSendingCommandInterface::class);

            return new SendNotificationsToUsersAtTimeCommand($getStatementSendingScheduleByTimeCommand, $userNotifyCommand, $getStatementForSendingCommand);
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
