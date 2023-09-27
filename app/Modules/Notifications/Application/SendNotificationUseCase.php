<?php

namespace App\Modules\Notifications\Application;

use App\Models\User;
use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;
use App\Modules\User\Application\SaveIdOfLastSentStatementUseCase;

class SendNotificationUseCase
{

    public function __construct(private User $user, private string $text, private StatementNotificationSystemInterface $statementNotificationSystem)
    {
    }

    public function execute(){
        $this->statementNotificationSystem->setMessageText($this->text);

        $this->user->notify($this->statementNotificationSystem);
    }
}
