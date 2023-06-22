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
     * Функция для отправлений сообщений, о том что у пользователя нет высказываний для отправки
     * @param int $userId
     * @return void
     */
    public function sendNotificationAboutNoStatementsForSending(int $userId){
        $telegramNotification = new TelegramNotification();
        $telegramNotification->setMessageText('There is no statements for sending');
        $user = User::find($userId);
        $user->notify($telegramNotification);
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

                $telegramWeeklyNotification = new TelegramNotification();
                $telegramWeeklyNotification->setMessageText($weeklyNotificationText);
                $user->notify($telegramWeeklyNotification);
            }

    }
}
