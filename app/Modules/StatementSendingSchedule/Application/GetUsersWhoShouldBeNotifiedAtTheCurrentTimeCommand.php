<?php

namespace App\Modules\StatementSendingSchedule\Application;

use App\Modules\StatementSendingSchedule\Domain\StatementSendingScheduleRepositoryInterface;

class GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand
{

    public function __construct(private StatementSendingScheduleRepositoryInterface $statementSendingScheduleRepository)
    {
    }

    public function execute(string $currentTime){

    }

}
