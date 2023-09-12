<?php

namespace App\Classes\WeeklyNotification;

use Illuminate\Support\Collection;

interface WeeklyNotificationTextInterface
{
    public function createText(Collection $userResponses);
}
