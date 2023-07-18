<?php

namespace App\Domains\WeeklyNotification;

use Illuminate\Support\Collection;

class CreateWeeklyNotificationTextCommand
{
    public function __construct(private Collection $userResponses){

    }

    /**
     * Функция для формирования текста за неделю для отправки пользователю
     * @return string
     */
    public function execute(){
        $weeklyNotificationText = '';

        for($i=0; $i<count($this->userResponses); $i++){
            $weeklyNotificationText .= $i . '. ' . $this->userResponses[$i]->text . PHP_EOL;
        }

        return $weeklyNotificationText;
    }
}