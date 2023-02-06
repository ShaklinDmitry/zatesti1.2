<?php

namespace App\Services;

use App\DTO\UserResponseDTO;
use Carbon\Carbon;
use http\Env\Request;
use NotificationChannels\Telegram\TelegramUpdates;
use App\Models\UserResponse;

class UserResponseService
{

    public function __construct(){}

    /**
     * Функция для сохранения ответа пользователя
     * @param UserResponseRequest $request
     * @return mixed
     */
    public function saveUserResponse(string $chatId, string $text){

        $userResponse = UserResponse::create(
            [
                "telegram_chat_id" => $chatId,
                "text" => $text
            ]
        );

        return $userResponse;
    }

    /**
     * Получить ответы пользователей за эту неделю
     * @return mixed
     * @throws \Exception
     */
    public function getUserResponsesForThisWeek(){
        $now = Carbon::now();

        $currentDate = $now->format('Y-m-d H:i');
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');

        $userResponses = UserResponse::whereBetween('created_at',[$weekStartDate, $currentDate])->get();

        if($userResponses->isEmpty()){
            throw new \Exception("No user responses this week");
        }

        return $userResponses;
    }

}
