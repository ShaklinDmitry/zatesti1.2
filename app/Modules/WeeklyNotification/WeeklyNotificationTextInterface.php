<?php

namespace App\Modules\WeeklyNotification;

use Illuminate\Support\Collection;

interface WeeklyNotificationTextInterface
{
    public function createText(Collection $userResponses);
}
