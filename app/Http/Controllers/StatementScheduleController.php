<?php

namespace App\Http\Controllers;

use App\Classes\Notifications\Interfaces\StatementNotificationSystem;
use App\Classes\Statements\Infrastructure\Jobs\SendStatements;
use App\Classes\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand;
use App\Classes\WeeklyNotification\WeeklyNotification;
use App\Classes\WeeklyNotification\WeeklyNotificationSender;
use App\Classes\WeeklyNotification\WeeklyNotificationText;
use App\Models\StatementSendingSchedule;
use App\Models\UserResponse;
use App\Services\StatementScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StatementScheduleController extends Controller
{
    /**
     * Для вызова в кроне каждую минуту
     * @return void
     * @throws \Exception
     */
    public function executeEveryMinute(StatementNotificationSystem $statementNotification){

        try{
            $getUsersWhoShouldBeNotifiedAtTheCurrentTime = new GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand(date("H:i"));
            $users = $getUsersWhoShouldBeNotifiedAtTheCurrentTime->execute();

            SendStatements::dispatch($users, $statementNotification);

        }catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }

    /**
     * Для вызова в кроне раз в неделю в воскресенье
     * @return string
     */
    public function executeEverySunday(StatementNotificationSystem $statementNotificationSystem){

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

        $saveExactTime = $statementSendingSchedule->fillWithTimeForSending($request->exactTimes, Auth::id());

        if($saveExactTime){
            $responseData = [
                "data" => [
                    "message" => "Time for sending statements was saved successful",
                ]
            ];
        }

        return response() -> json($responseData,200);
    }
}
