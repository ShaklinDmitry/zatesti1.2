<?php

namespace App\Classes\StatementSendingSchedule\Interfaces;

interface StatementSendingScheduleInterface
{
    public function fillWithTimeForSending(string $times, int $userId);

    public function getUsersWhoShouldBeNotifiedThisWeek();
}
