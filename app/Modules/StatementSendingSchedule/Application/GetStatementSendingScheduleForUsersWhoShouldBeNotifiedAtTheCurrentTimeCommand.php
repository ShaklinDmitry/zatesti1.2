<?php

namespace App\Modules\StatementSendingSchedule\Application;

use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTO;
use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTOCollection;
use App\Modules\StatementSendingSchedule\Domain\StatementSendingScheduleRepositoryInterface;

class GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand
{
    /**
     * @param StatementSendingScheduleRepositoryInterface $statementSendingScheduleRepository
     */
    public function __construct(private StatementSendingScheduleRepositoryInterface $statementSendingScheduleRepository)
    {
    }

    /**
     * @param string $currentTime
     * @return StatementSendingScheduleDTOCollection
     */
    public function execute(string $currentTime):StatementSendingScheduleDTOCollection{
        $statementSendingScheduleDTOCollection = $this->statementSendingScheduleRepository->getStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTime($currentTime);

        return $statementSendingScheduleDTOCollection;
    }

}
