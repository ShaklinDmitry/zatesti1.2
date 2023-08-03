<?php

namespace App\classes\Notifications;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;
use App\Models\Statement;
use App\Models\User;

class SendNotificationCommand
{
    private $statementNotification;

    public function __construct(StatementNotificationSystem $statementNotification)
    {
        $this->statementNotification = $statementNotification;
    }

    /**
     * Для отправки уведомлений с высказываниями
     * @param int $userId
     * @return bool|string
     * @throws \Exception
     */
    public function execute(int $userId, Statement $statement)
    {
        $this->statementNotification->setMessageText($statement->text);

        $saveIdOfLastSentStatementCommand = new SaveIdOfLastSentStatementCommand();
        $saveIdOfLastSentStatementCommand->execute($userId, $statement->id);

        $user = User::find($userId);
        $user->notify($this->statementNotification);
    }
}
