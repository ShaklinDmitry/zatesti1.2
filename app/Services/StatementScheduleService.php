<?php

namespace App\Services;

use App\Models\StatementSendingSchedule;

class StatementScheduleService
{

    /**
     * Функция для сохранения конкретного времени, по которому будет осуществляться отправка высказываний
     * @param string $times
     * @param int $userId
     * @return bool
     */
    public function saveExactTimeForSendingStatements(string $times,int $userId){
        $times = explode(";", $times);

        foreach ($times as $time){
            StatementSendingSchedule::create([
                'user_id' => $userId,
                'exact_time' => $time
            ]);
        }

        return true;
    }


    /**
     * Функция для получения списка пользователей которым нужно отправить высказывание
     * @param string $currentTime
     * @return mixed
     */
    public function getUsersWhoAccordingToTheScheduleShouldSendMessage(string $currentTime){

        return StatementSendingSchedule::where('exact_time', $currentTime)->get('user_id')->toArray();

    }

}
