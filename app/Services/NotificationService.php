<?php

namespace App\Services;

use App\Domains\Notifications\TelegramNotification;
use App\Domains\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedThisWeekCommand;
use App\Models\User;

class NotificationService
{

    /**
     * Функция для отправлений сообщений, о том что у пользователя нет высказываний для отправки
     * @param int $userId
     * @return void
     */
//    public function sendNotificationAboutNoStatementsForSending(int $userId){
//        $telegramNotification = new TelegramNotification();
//        $telegramNotification->setMessageText('There is no statements for sending');
//        $user = User::find($userId);
//        $user->notify($telegramNotification);
//    }

    /**
     * Для рассылки недельного отчета. Здесь рассылаются обратно пользователю те высказывания, которые он отправил приложению
     * @return string|void
     */
    public function sendWeeklyReport(){
            $getUsersWhoShouldBeNotifiedThisWeek = new GetUsersWhoShouldBeNotifiedThisWeekCommand();
            $usersWhoShouldBeNotifiedThisWeek = $getUsersWhoShouldBeNotifiedThisWeek->execute();

            $userResponseService = new UserResponseService();
            foreach ($usersWhoShouldBeNotifiedThisWeek as $user){

                $userResponses = $userResponseService->getUserResponsesForThisWeek($user->telegram_chat_id);

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
