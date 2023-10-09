<?php

namespace App\Modules\StatementSendingSchedule\Infrastructure\Repositories;


use App\Models\StatementSendingSchedule;
use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTOCollection;
use App\Modules\StatementSendingSchedule\Domain\StatementSendingScheduleRepositoryInterface;
use App\Modules\StatementSendingSchedule\Infrastructure\Exception\NoUsersForWeeklyNotificationsException;
use App\Modules\StatementSendingSchedule\Infrastructure\Exception\NoUsersWhoScheduledToReceiveStatementNotificationException;

class StatementSendingScheduleRepository implements StatementSendingScheduleRepositoryInterface
{
    /**
     * @return array
     * @throws NoUsersForWeeklyNotificationsException
     */
    public function getUsersWhoShouldBeNotifiedThisWeek():array
    {
        $listOfUsersInSchedule = StatementSendingSchedule::distinct()->get(['user_id']);

        if($listOfUsersInSchedule->isEmpty()){
            throw new NoUsersForWeeklyNotificationsException();
        }

        return $listOfUsersInSchedule->toArray();

    }

    /**
     * @param string $currentTime
     * @return array
     * @throws NoUsersWhoScheduledToReceiveStatementNotificationException
     */
    public function getUsersWhoShouldBeNotifiedAtTheCurrentTime(string $currentTime):array{
        $statementSendingSchedule = StatementSendingSchedule::where('exact_time', $currentTime)->get();

        if($statementSendingSchedule->isEmpty()){
            throw new NoUsersWhoScheduledToReceiveStatementNotificationException();
        }

        return $statementSendingSchedule->toArray();
    }
}
