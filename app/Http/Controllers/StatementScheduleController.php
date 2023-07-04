<?php

namespace App\Http\Controllers;

use App\Domains\Notifications\Interfaces\StatementNotification;
use App\Domains\Statements\SendStatementCommand;
use App\Domains\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand;
use App\Services\NotificationService;
use App\Services\StatementScheduleService;
use App\Services\StatementService;
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
    public function executeEveryMinute(StatementNotification $statementNotification){

        try{
            $sendStatements = new SendStatementCommand($statementNotification);

            $getUsersWhoShouldBeNotifiedAtTheCurrentTime = new GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand(date("H:i"));
            $users = $getUsersWhoShouldBeNotifiedAtTheCurrentTime->execute();

            $sendStatements->execute($users);
        }catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }

    /**
     * Для вызова в кроне раз в неделю в воскресенье
     * @return string
     */
    public function executeEverySunday(){

        try{
            $notificationService = new NotificationService();
            $notificationService->sendWeeklyReport();
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
    public function setSendTime(Request $request, StatementScheduleService $statementScheduleService): JsonResponse{

        $saveExactTime = $statementScheduleService->saveExactTimeForSendingStatements($request->exactTimes, Auth::id());

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
