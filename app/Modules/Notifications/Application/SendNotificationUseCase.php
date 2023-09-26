<?php

namespace App\Modules\Notifications\Application;

use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;
use App\Modules\User\Application\SaveIdOfLastSentStatementUseCase;

class SendNotificationUseCase
{

    public function __construct(private int $userId, private string $text, private StatementNotificationSystemInterface $statementNotificationSystem)
    {
    }

    public function execute(){
        $this->statementNotificationSystem->setMessageText($this->text);

        //TODO сделать здесь event отправки уведомления


    }
}
