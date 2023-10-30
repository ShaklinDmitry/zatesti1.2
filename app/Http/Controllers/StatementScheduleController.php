<?php

namespace App\Http\Controllers;

use App\Models\StatementSendingSchedule;
use App\Models\UserResponse;
use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;
use App\Modules\Statements\Infrastructure\Jobs\SendStatements;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleByTimeCommand;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleByTimeCommandInterface;
use App\Modules\StatementSendingSchedule\Infrastructure\Repositories\StatementSendingScheduleRepository;
use App\Modules\WeeklyNotification\WeeklyNotification;
use App\Modules\WeeklyNotification\WeeklyNotificationSender;
use App\Modules\WeeklyNotification\WeeklyNotificationText;
use App\Services\StatementScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatementScheduleController extends Controller
{
    /**
     * Для вызова в кроне каждую минуту
     * @return void
     * @throws \Exception
     */
//    public function executeEveryMinute(StatementNotificationSystemInterface $statementNotification, GetStatementSendingScheduleByTimeCommandInterface $getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand){
//
//        try{
//            $currentTime = date("H:i");
//
//            $statementSendingSchedule = $getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand->execute($currentTime);
//
//            foreach ($statementSendingSchedule->getCollection() as $statementSendingScheduleDTO){
//
//            }
//
//            SendStatements::dispatch($users, $statementNotification);
//
//        }catch(\Exception $exception){
//            Log::info($exception->getMessage());
//        }
//
//    }

    /**
     * Для вызова в кроне раз в неделю в воскресенье
     * @return string
     */
    public function executeEverySunday(StatementNotificationSystemInterface $statementNotificationSystem){

        try{
            $weeklyNotification = new WeeklyNotification(new StatementSendingSchedule(), new UserResponse(), new WeeklyNotificationText());
            $userWeeklyNotifications = $weeklyNotification->getUserWeeklyNotifications();

            foreach ($userWeeklyNotifications as $userWeeklyNotification){
                $weeklyNotificationSender = new WeeklyNotificationSender($statementNotificationSystem, $userWeeklyNotification);
                $weeklyNotificationSender->sendWeeklyNotification();
            }
        }catch(\Exception $exception){
            Log::info($exception->getMessage());
            return $exception->getMessage();
        }
    }

}
