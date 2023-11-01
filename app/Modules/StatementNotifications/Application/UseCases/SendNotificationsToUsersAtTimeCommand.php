<?php

namespace App\Modules\StatementNotifications\Application\UseCases;

use App\Modules\Statements\Application\UseCases\GetStatementForSendingCommand;
use App\Modules\Statements\Application\UseCases\GetStatementForSendingCommandInterface;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleByTimeCommandInterface;
use App\Modules\User\Application\UseCases\UserNotifyCommandInterface;

class SendNotificationsToUsersAtTimeCommand implements SendNotificationsToUsersAtTimeCommandInterface
{

    /**
     * @param GetStatementSendingScheduleByTimeCommandInterface $getStatementSendingScheduleByTimeCommand
     * @param UserNotifyCommandInterface $userNotifyCommand
     * @param GetStatementForSendingCommandInterface $getStatementForSendingCommand
     */
    public function __construct(private GetStatementSendingScheduleByTimeCommandInterface $getStatementSendingScheduleByTimeCommand, private UserNotifyCommandInterface $userNotifyCommand, private GetStatementForSendingCommandInterface $getStatementForSendingCommand)
    {
    }

    /**
     * @param string $time
     * @return mixed|void
     */
    public function execute(string $time){
        $statementSendingScheduleCollection = $this->getStatementSendingScheduleByTimeCommand->execute($time)->getCollection();
        foreach ($statementSendingScheduleCollection as $statementSendingSchedule){
                $statement = $this->getStatementForSendingCommand->execute($statementSendingSchedule->userId);
                $this->userNotifyCommand->execute($statementSendingSchedule->userId, $statement->text);
        }
    }
}
