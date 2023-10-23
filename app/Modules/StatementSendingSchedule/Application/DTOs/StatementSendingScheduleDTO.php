<?php

namespace App\Modules\StatementSendingSchedule\Application\DTOs;

class StatementSendingScheduleDTO
{ 

    public function __construct(public string $guid, public int $userId, public string $exactTime)
    {
    }
}
