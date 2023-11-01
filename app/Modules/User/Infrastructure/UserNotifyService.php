<?php

namespace App\Modules\User\Infrastructure;

use App\Models\User;
use App\Modules\StatementNotifications\Domain\StatementNotificationInterface;
use App\Modules\User\Domain\UserNotifyServiceInterface;

class UserNotifyService implements UserNotifyServiceInterface
{
    /**
     * @param StatementNotificationInterface $statementNotification
     */
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
