<?php

namespace App\Modules\StatementSendingSchedule;

use App\Modules\StatementSendingSchedule\Exception\NoUsersWhoScheduledToReceiveStatementNotificationException;
use App\Models\StatementSendingSchedule;
use App\Models\User;

class GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand
{
    private string $currentTime;

    public function __construct(string $currentTime){
        $this->currentTime = $currentTime;
    }


    /**
     * Функция для получения списка пользователей которым нужно отправить высказывание
     * @param string $currentTime
     * @return array
     * @throws \Exception
     */
    public function execute(): array{
        $statementSendingSchedule = StatementSendingSchedule::where('exact_time', $this->currentTime)->get();

        if($statementSendingSchedule->isEmpty()){
            throw new NoUsersWhoScheduledToReceiveStatementNotificationException();
        }

        $users = [];
        foreach ($statementSendingSchedule as $scheduleRow){
            $users[] = User::find($scheduleRow->user_id);
        }

        return $users;
    }
}
