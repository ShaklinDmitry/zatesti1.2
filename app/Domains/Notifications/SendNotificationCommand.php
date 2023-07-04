<?php

namespace App\Domains\Notifications;

use App\Domains\Notifications\Interfaces\StatementNotification;
use App\Models\Statement;
use App\Models\User;

class SendNotificationCommand
{
    private $statementNotification;

    public function __construct(StatementNotification $statementNotification)
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
