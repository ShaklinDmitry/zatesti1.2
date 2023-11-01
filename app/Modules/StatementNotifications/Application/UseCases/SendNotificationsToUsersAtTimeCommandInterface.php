<?php

namespace App\Modules\StatementNotifications\Application\UseCases;

interface SendNotificationsToUsersAtTimeCommandInterface
{
    /**
     * @param string $time
     * @return mixed
     */
    public function execute(string $time);
}
