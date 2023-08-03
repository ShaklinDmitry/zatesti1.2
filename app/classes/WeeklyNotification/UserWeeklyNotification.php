<?php

namespace App\classes\WeeklyNotification;

use App\Models\User;

class UserWeeklyNotification
{
    public function __construct(public User $user, public string $text){

    }
}
