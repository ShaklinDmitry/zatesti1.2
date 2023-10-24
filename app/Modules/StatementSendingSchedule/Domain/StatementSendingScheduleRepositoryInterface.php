<?php

namespace App\Modules\StatementSendingSchedule\Domain;

interface StatementSendingScheduleRepositoryInterface
{
    public function getStatementSendingScheduleForUsersWhoShouldBeNotifiedThisWeek();

    /**
     * @param \DateTime $currentTime
     * @return mixed
     */
    public function getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTime(string $currentTime);
}
