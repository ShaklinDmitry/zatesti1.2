<?php

namespace App\Services;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;
use App\classes\Notifications\TelegramNotificationSystem;
use App\classes\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedThisWeekCommand;
use App\classes\UserResponses\GetUserResponsesForThisWeekCommand;
use App\classes\WeeklyNotification\CreateWeeklyNotificationTextCommand;
use App\classes\WeeklyNotification\SendWeeklyNotificationCommand;
use App\classes\WeeklyNotification\UserWeeklyNotification;
use App\Models\User;

class NotificationService
{

    /**
     * Функция для отправлений сообщений, о том что у пользователя нет высказываний для отправки
     * @param int $userId
     * @return void
     */
//    public function sendNotificationAboutNoStatementsForSending(int $userId){
//        $telegramNotification = new TelegramNotificationSystem();
//        $telegramNotification->setMessageText('There is no statements for sending');
//        $user = User::find($userId);
//        $user->notify($telegramNotification);
//    }

    /**
     * Для рассылки недельного отчета. Здесь рассылаются обратно пользователю те высказывания, которые он отправил приложению
     * @return string|void
     */
//    public function sendWeeklyReport(StatementNotificationSystem $statementNotificationSystem, UserWeeklyNotification $userWeeklyNotification){
//        $sendWeeklyNotification = new SendWeeklyNotificationCommand($statementNotificationSystem, $userWeeklyNotification->user, $userWeeklyNotification->text);
//        $sendWeeklyNotification->execute();
//    }
}
