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
    public function saveUserResponse(UserResponseRequest $request){

        $userResponse = UserResponse::create(
            [
                "telegram_chat_id" => $request['message']['chat']['id'],
                "text" => $request['message']['text']
            ]
        );



        return $userResponse;
    }

}
