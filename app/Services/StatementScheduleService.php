<?php

namespace App\Services;

use App\Models\StatementSendingSchedule;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class StatementScheduleService
{
    /**
     * Функция для сохранения конкретного времени, по которому будет осуществляться отправка высказываний
     * @param string $times
     * @param int $userId
     * @return bool
     */
    public function saveExactTimeForSendingStatements(string $times,int $userId): bool{
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
     * @return array
     * @throws \Exception
     */
    public function getUsersWhoShouldBeNotifiedAtTheCurrentTime(string $currentTime): array{

        $statementSendingSchedule = StatementSendingSchedule::where('exact_time', $currentTime)->get();

        if($statementSendingSchedule->isEmpty()){
            throw new \Exception('There are no users who are scheduled to receive a statement notification');
        }

        $users = [];
        foreach ($statementSendingSchedule as $scheduleRow){
            $users[] = User::find($scheduleRow->user_id);
        }

        return $users;
    }


    /**
     * Функция для того чтобы получить список пользователей, которым будет проводиться результирующая рассылка на этой неделе
     * @return mixed
     * @throws \Exception
     */
    public function getUsersWhoShouldBeNotifiedThisWeek(){

        $listOfUsersInSchedule = StatementSendingSchedule::distinct()->get(['user_id']);

        if($listOfUsersInSchedule->isEmpty()){
            throw new \Exception('No users for weekly notifications');
        }

        $users = [];
        foreach ($listOfUsersInSchedule as $userRow){
            $users[] = User::find($userRow->user_id);
        }

        return $users;
    }

}
