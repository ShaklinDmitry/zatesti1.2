<?php

namespace App\Domains\Notifications;

use App\Models\User;

class SendNotificationAboutNoStatementsForSendingCommand
{
    /**
     * Функция для отправлений сообщений, о том что у пользователя нет высказываний для отправки
     * @param int $userId
     * @return void
     */
    public function execute(int $userId){
        $telegramNotification = new TelegramNotification();
        $telegramNotification->setMessageText('There is no statements for sending');
        $user = User::find($userId);
        $user->notify($telegramNotification);
    }
}