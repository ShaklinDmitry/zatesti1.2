<?php

namespace App\classes\WeeklyNotification;

use App\classes\WeeklyNotification\Exceptions\CreateWeeklyNotificationTextException;
use Illuminate\Support\Collection;

class CreateWeeklyNotificationTextCommand
{
    public function __construct(private Collection $userResponses){

    }

    /**
     * Функция для формирования текста за неделю для отправки пользователю
     * @return string
     */
//    public function execute(){
//        if($this->userResponses->isEmpty()){
//            throw new CreateWeeklyNotificationTextException('There is no user responses');
//        }
//
//        $weeklyNotificationText = '';
//
//        for($i=0; $i<count($this->userResponses); $i++){
//            $weeklyNotificationText .= $i . '. ' . $this->userResponses[$i]->text . PHP_EOL;
//        }
//
//        return $weeklyNotificationText;
//    }
}
