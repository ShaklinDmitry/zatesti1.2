<?php

namespace App\Modules\StatementSendingSchedule\Infrastructure\Repositories;


use App\Models\StatementSendingSchedule;
use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTO;
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
    public function getStatementSendingScheduleForUsersWhoShouldBeNotifiedThisWeek():array
    {
        $listOfUsersInSchedule = StatementSendingSchedule::distinct()->get(['user_id']);

        if($listOfUsersInSchedule->isEmpty()){
            throw new NoUsersForWeeklyNotificationsException();
        }

        return $listOfUsersInSchedule->toArray();

    }

    /**
     * @param string $currentTime
     * @return StatementSendingScheduleDTOCollection
     * @throws NoUsersWhoScheduledToReceiveStatementNotificationException
     */
    public function getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTime(string $currentTime): StatementSendingScheduleDTOCollection{
        $statementSendingSchedule = StatementSendingSchedule::where('exact_time', $currentTime)->get();

        if($statementSendingSchedule->isEmpty()){
            throw new NoUsersWhoScheduledToReceiveStatementNotificationException();
        }

        $statementSendingScheduleDTOCollection = new StatementSendingScheduleDTOCollection();
        foreach ($statementSendingSchedule as $statementSendingScheduleValue){
            $statementSendingScheduleDTO = new StatementSendingScheduleDTO($statementSendingScheduleValue->guid, $statementSendingScheduleValue->user_id, $statementSendingScheduleValue->exact_time);
            $statementSendingScheduleDTOCollection->addDTOToCollection($statementSendingScheduleDTO);
        }

        return $statementSendingScheduleDTOCollection;
    }
}
