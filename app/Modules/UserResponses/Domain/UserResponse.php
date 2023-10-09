<?php

namespace App\Modules\UserResponses\Domain;


use App\Modules\UserResponses\Exception\NoUserResponsesForThisWeekException;

class UserResponse implements UserResponseInterface
{
    public function getUserResponsesForThisWeek(int $telegram_chat_id)
    {
        $currentDate = now()->format('Y-m-d H:i');
        $weekStartDate = now()->startOfWeek()->format('Y-m-d H:i');

        $userResponses = \App\Models\UserResponse::whereBetween('created_at',[$weekStartDate, $currentDate])->where('telegram_chat_id', $telegram_chat_id)->get();

        if($userResponses->isEmpty()){
            throw new NoUserResponsesForThisWeekException();
        }

        return $userResponses;
    }
}
