<?php

namespace App\Modules\Notifications;

use App\Models\StatementEloquent;
use App\Models\User;
use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;

class SendNotificationCommand
{
    private $statementNotification;

    public function __construct(StatementNotificationSystemInterface $statementNotification)
    {
        $this->statementNotification = $statementNotification;
    }

    /**
     * Для отправки уведомлений с высказываниями
     * @param int $userId
     * @return bool|string
     * @throws \Exception
     */
    public function execute(int $userId, StatementEloquent $statement)
    {
        $this->statementNotification->setMessageText($statement->text);

        $saveIdOfLastSentStatementCommand = new SaveIdOfLastSentStatementCommand();
        $saveIdOfLastSentStatementCommand->execute($userId, $statement->id);

        $user = User::find($userId);
        $user->notify($this->statementNotification);
    }
}
