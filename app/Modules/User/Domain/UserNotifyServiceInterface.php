<?php

namespace App\Modules\User\Domain;

interface UserNotifyServiceInterface
{
    /**
     * @param int $userId
     * @param string $text
     * @return mixed
     */
    public function notifyUser(int $userId, string $text);
}
