<?php

namespace App\Modules\WeeklyNotification;

use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;

class WeeklyNotificationSender implements WeeklyNotificationSenderInterface
{
    public function __construct(private StatementNotificationSystemInterface $statementNotificationSystem, private UserWeeklyNotificationDTO $userWeeklyNotification){
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
