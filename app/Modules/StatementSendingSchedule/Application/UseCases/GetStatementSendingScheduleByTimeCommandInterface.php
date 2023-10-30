<?php

namespace App\Modules\StatementSendingSchedule\Application\UseCases;

use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTOCollection;

interface GetStatementSendingScheduleByTimeCommandInterface
{
    /**
     * @param string $currentTime
     * @return StatementSendingScheduleDTOCollection
     */
    public function execute(string $currentTime): StatementSendingScheduleDTOCollection;
}
