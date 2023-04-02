<?php

namespace App\Services;

use App\Models\Statement;
use App\Models\User;
use App\Models\UserResponse;
use App\Notifications\TelegramNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class NotificationService
{

    /**
     * Для отправки уведомлений с высказываниями
     * @param int $userId
     * @return bool|string
     * @throws \Exception
     */
    public function sendNotification(int $userId, Statement $statement){
        try{
            $telegramNotification = new TelegramNotification($statement->text);

            $user = User::find($userId);
            $user->last_statement_id_sent = $statement->id;
            $user->save();

            $user->notify($telegramNotification);

        }catch(Exception $e) {

            return $e->getMessage();

        }
    }


    /**
     * Для рассылки недельного отчета. Здесь рассылаются обратно пользователю те высказывания, которые он отправил приложению
     * @return string|void
     */
    public function sendWeeklyReport(){
            $statementScheduleService = new StatementScheduleService();
            $usersWhoShouldBeNotifiedThisWeek = $statementScheduleService->getUsersWhoShouldBeNotifiedThisWeek();

            $userResponseService = new UserResponseService();
            foreach ($usersWhoShouldBeNotifiedThisWeek as $user){

                $userResponses = $userResponseService->getUserResponsesForThisWeek($user);

                if($userResponses->isEmpty())
                    continue;

                $weeklyNotificationText = '';

                for($i=0; $i<count($userResponses); $i++){
                    $weeklyNotificationText .= $i . '. ' . $userResponses[$i]->text . PHP_EOL;
                }

                $telegramWeeklyNotification = new TelegramNotification($weeklyNotificationText);
                $user->notify($telegramWeeklyNotification);
            }

    }
}
