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
    public function getUserIdsWhoShouldBeNotifiedAtTheCurrentTime(string $currentTime){

        $userIds = StatementSendingSchedule::select('user_id')->where('exact_time', $currentTime)->get()->toArray();

        if($userIds == null){
            throw new \Exception('There are no users who are scheduled to receive a statement notification');
        }

        return $userIds;

    }

}
