<?php

namespace App\Modules\StatementSendingSchedule\Application\DTOs;

class StatementSendingScheduleDTO
{

    public function __construct(public int $id, public int $userId, public string $exactTime)
    {
    }
}
