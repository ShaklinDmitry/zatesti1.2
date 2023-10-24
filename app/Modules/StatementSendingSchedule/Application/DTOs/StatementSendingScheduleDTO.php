<?php

namespace App\Modules\StatementSendingSchedule\Application\DTOs;

class StatementSendingScheduleDTO
{

    /**
     * @param string $guid
     * @param int $userId
     * @param string $exactTime
     */
    public function __construct(public string $guid, public int $userId, public string $exactTime)
    {
    }
}
