<?php

namespace App\Modules\StatementSendingSchedule\Domain;

interface StatementSendingScheduleRepositoryInterface
{
    public function getUsersWhoShouldBeNotifiedThisWeek();

    public function getUsersWhoShouldBeNotifiedAtTheCurrentTime(string $currentTime);
}
