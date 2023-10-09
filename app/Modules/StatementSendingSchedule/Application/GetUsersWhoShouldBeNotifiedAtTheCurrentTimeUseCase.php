<?php

namespace App\Modules\StatementSendingSchedule\Application;

use App\Modules\StatementSendingSchedule\Domain\StatementSendingScheduleRepositoryInterface;

class GetUsersWhoShouldBeNotifiedAtTheCurrentTimeUseCase
{

    public function __construct(private string $currentTime, private StatementSendingScheduleRepositoryInterface $statementSendingScheduleRepository)
    {
    }

    public function execute(){

    }

}
