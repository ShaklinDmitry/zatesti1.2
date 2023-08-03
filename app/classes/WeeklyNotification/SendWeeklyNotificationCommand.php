<?php

namespace App\classes\WeeklyNotification;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;
use App\classes\Notifications\TelegramNotificationSystem;
use App\Models\User;

class SendWeeklyNotificationCommand
{

    public function __construct(private StatementNotificationSystem $statementNotification, private UserWeeklyNotification $userWeeklyNotification){
    }

    /**
     * функция для отправки уведомления пользователю
     * @return void
     */
    public function execute(){
        $this->statementNotification->setMessageText($this->userWeeklyNotification->text);
        $this->userWeeklyNotification->user->notify($this->statementNotification);
    }
}
