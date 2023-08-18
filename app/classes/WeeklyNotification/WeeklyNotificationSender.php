<?php

namespace App\classes\WeeklyNotification;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;

class WeeklyNotificationSender implements WeeklyNotificationSenderInterface
{
    public function __construct(private StatementNotificationSystem $statementNotificationSystem, private UserWeeklyNotificationDTO $userWeeklyNotification){
    }


    /**
     * функция для отправки уведомления пользователю
     * @return void
     */
    public function sendWeeklyNotification()
    {
        $this->statementNotificationSystem->setMessageText($this->userWeeklyNotification->text);
        $this->userWeeklyNotification->user->notify($this->statementNotificationSystem);
    }
}
