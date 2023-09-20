<?php

namespace App\Modules\WeeklyNotification;

use App\Models\User;

class UserWeeklyNotificationDTO
{
    public function __construct(public User $user, public string $text)
    {
    }
}
