<?php

namespace App\Http\Controllers;

use App\Models\StatementSendingSchedule;
use App\Models\UserResponse;
use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;
use App\Modules\Statements\Infrastructure\Jobs\SendStatements;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommandInterface;
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
    public function executeEveryMinute(StatementNotificationSystemInterface $statementNotification, GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommandInterface $getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand){

        try{
            $currentTime = date("H:i");

            $statementSendingSchedule = $getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand->execute($currentTime);

            foreach ($statementSendingSchedule->getCollection() as $statementSendingScheduleDTO){

            }

            SendStatements::dispatch($users, $statementNotification);

        }catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }

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

    /**
     * Для сохранения времени когда нужно отправлять пользователям высказывания
     * @param Request $request
     * @param StatementScheduleService $statementScheduleService
     * @return \Illuminate\Http\JsonResponse
     */
    public function setSendTime(Request $request, StatementSendingSchedule $statementSendingSchedule): JsonResponse{

//        $saveExactTime = $statementSendingSchedule->fillWithTimeForSending($request->exactTimes, Auth::id());
//
//        if($saveExactTime){
//            $responseData = [
//                "data" => [
//                    "message" => "Time for sending statements was saved successful",
//                ]
//            ];
//        }
//
//        return response() -> json($responseData,200);

        return 'doit later';
    }
}
