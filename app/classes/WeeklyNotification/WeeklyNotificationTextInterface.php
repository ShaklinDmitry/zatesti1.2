<?php

namespace App\classes\WeeklyNotification;

use Illuminate\Support\Collection;

interface WeeklyNotificationTextInterface
{
    public function createText(Collection $userResponses);
}
