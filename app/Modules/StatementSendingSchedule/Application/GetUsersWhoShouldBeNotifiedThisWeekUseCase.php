<?php

namespace App\Modules\StatementSendingSchedule\Application;

use App\Modules\StatementSendingSchedule\Domain\StatementSendingScheduleRepositoryInterface;

class GetUsersWhoShouldBeNotifiedThisWeekUseCase
{

    public function __construct(private StatementSendingScheduleRepositoryInterface $statementSendingScheduleRepository)
    {
    }

    public function execute(){
        $usersWhoShouldBeNotifiedThisWeek = $this->statementSendingScheduleRepository->getUsersWhoShouldBeNotifiedThisWeek();

        return $usersWhoShouldBeNotifiedThisWeek;
    }
}
