<?php

namespace App\Modules\StatementSendingSchedule\Application\UseCases;

use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTOCollection;

interface GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommandInterface
{
    /**
     * @param string $currentTime
     * @return StatementSendingScheduleDTOCollection
     */
    public function execute(string $currentTime): StatementSendingScheduleDTOCollection;
}
