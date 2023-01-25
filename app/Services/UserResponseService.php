<?php

namespace App\Services;

use App\DTO\UserResponseDTO;
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

}
