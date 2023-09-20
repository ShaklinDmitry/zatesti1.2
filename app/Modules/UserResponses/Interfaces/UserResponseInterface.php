<?php

namespace App\Modules\UserResponses\Interfaces;

use App\Models\User;

interface UserResponseInterface
{
    public function getUserResponsesForThisWeek(int $telegram_chat_id);
}
