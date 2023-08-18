<?php

namespace App\classes\WeeklyNotification;

use App\Models\User;
use Illuminate\Support\Collection;

interface WeeklyNotificationInterface
{
    public function getUserWeeklyNotifications();
}
