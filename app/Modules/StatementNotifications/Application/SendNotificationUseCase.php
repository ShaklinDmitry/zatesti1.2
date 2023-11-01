<?php

namespace App\Modules\StatementNotifications\Application;

use App\Models\User;
use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;

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
