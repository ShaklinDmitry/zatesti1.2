<?php

namespace App\Modules\User\Infrastructure;

use App\Models\User;
use App\Modules\Notifications\Domain\StatementNotificationInterface;

class UserNotifyService implements UserNotifyServiceInterface
{
    public function __construct(private StatementNotificationInterface $statementNotification)
    {
    }


    /**
     * @param int $userId
     * @param string $text
     * @param StatementNotificationInterface $statementNotification
     * @return void
     */
    public function notifyUser(int $userId, string $text){
        $user = User::find($userId);
        $this->statementNotification->setMessageText($text);
        $user->notify($this->statementNotification);
    }
}
