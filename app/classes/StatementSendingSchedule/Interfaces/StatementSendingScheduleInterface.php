<?php

namespace App\classes\StatementSendingSchedule\Interfaces;

interface StatementSendingScheduleInterface
{
    public function fillWithTimeForSending(string $times, int $userId);
}
