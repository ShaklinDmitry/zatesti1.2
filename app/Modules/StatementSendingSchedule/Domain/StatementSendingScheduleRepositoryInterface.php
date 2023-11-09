<?php

namespace App\Modules\StatementSendingSchedule\Domain;

interface StatementSendingScheduleRepositoryInterface
{

    /**
     * @param \DateTime $currentTime
     * @return mixed
     */
    public function getStatementSendingScheduleByTime(string $currentTime);
}
