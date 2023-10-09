<?php

namespace App\Modules\UserResponses\Domain;

interface UserResponseInterface
{
    public function getUserResponsesForThisWeek(int $telegram_chat_id);
}
