<?php

namespace App\Modules\StatementNotifications\Application\UseCases;

use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleByTimeCommandInterface;
use App\Modules\User\Application\UseCases\UserNotifyCommandInterface;

class SendNotificationsToUsersAtTimeCommand
{

    public function __construct(private GetStatementSendingScheduleByTimeCommandInterface $getStatementSendingScheduleByTimeCommand, private UserNotifyCommandInterface $userNotifyCommand)
    {
    }

    public function execute(string $time){
        $statementSendingScheduleCollection = $this->getStatementSendingScheduleByTimeCommand->execute($time)->getCollection();
        foreach ($statementSendingScheduleCollection as $statementSendingSchedule){
                $this->userNotifyCommand->execute($statementSendingSchedule->userId, $time);
        }
    }
}
