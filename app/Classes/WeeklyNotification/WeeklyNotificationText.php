<?php

namespace App\Classes\WeeklyNotification;

use App\Classes\WeeklyNotification\Exceptions\CreateWeeklyNotificationTextException;
use Illuminate\Support\Collection;

class WeeklyNotificationText implements WeeklyNotificationTextInterface
{
    /**
     * Функция для формирования текста за неделю для отправки пользователю
     * @param Collection $userResponses
     * @return string
     * @throws CreateWeeklyNotificationTextException
     */
    public function createText(Collection $userResponses): string
    {
        if($userResponses->isEmpty()){
            throw new CreateWeeklyNotificationTextException('There is no user responses');
        }

        $weeklyNotificationText = '';

        for($i=0; $i<count($userResponses); $i++){
            $weeklyNotificationText .= $i . '. ' . $userResponses[$i]->text . PHP_EOL;
        }

        return $weeklyNotificationText;
    }
}
