<?php

namespace App\Modules\Notifications\Domain;

interface StatementNotificationSystemInterface
{
    /**
     * @param string $message
     * @return mixed
     */
    public function setMessageText(string $message);
}
