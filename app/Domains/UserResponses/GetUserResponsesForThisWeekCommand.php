<?php

namespace App\Domains\UserResponses;

use App\Domains\UserResponses\Exception\NoUserResponsesForThisWeekException;
use App\Models\User;
use App\Models\UserResponse;
use Illuminate\Support\Collection;

class GetUserResponsesForThisWeekCommand
{
    /**
     * Для рассылки недельного отчета. Здесь рассылаются обратно пользователю те высказывания, которые он отправил приложению
     * @param User $user
     * @return Collection
     * @throws NoUserResponsesForThisWeekException
     */
    public function execute(int $telegram_chat_id):Collection{
        $currentDate = now()->format('Y-m-d H:i');
        $weekStartDate = now()->startOfWeek()->format('Y-m-d H:i');

        $userResponses = UserResponse::whereBetween('created_at',[$weekStartDate, $currentDate])->where('telegram_chat_id', $telegram_chat_id)->get();

        if($userResponses->isEmpty()){
            throw new NoUserResponsesForThisWeekException();
        }

        return $userResponses;
    }
}
