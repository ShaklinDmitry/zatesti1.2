<?php

namespace App\Modules\StatementSendingSchedule\Application\UseCases;

use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTOCollection;
use App\Modules\StatementSendingSchedule\Domain\StatementSendingScheduleRepositoryInterface;

class GetStatementSendingScheduleByTimeCommand implements GetStatementSendingScheduleByTimeCommandInterface
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
