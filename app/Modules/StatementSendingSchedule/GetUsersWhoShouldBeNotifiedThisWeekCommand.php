<?php

namespace App\Modules\StatementSendingSchedule;

use App\Modules\StatementSendingSchedule\Exception\NoUsersForWeeklyNotificationsException;
use App\Models\StatementSendingSchedule;
use App\Models\User;

class GetUsersWhoShouldBeNotifiedThisWeekCommand
{
    /**
     * Функция для того чтобы получить список пользователей, которым будет проводиться результирующая рассылка на этой неделе
     * @return array
     * @throws NoUsersForWeeklyNotificationsException
     */
    public function execute(){
        $listOfUsersInSchedule = StatementSendingSchedule::distinct()->get(['user_id']);

        if($listOfUsersInSchedule->isEmpty()){
            throw new NoUsersForWeeklyNotificationsException();
        }

        $users = [];
        foreach ($listOfUsersInSchedule as $userRow){
            $users[] = User::find($userRow->user_id);
        }

        return $users;
    }
}
