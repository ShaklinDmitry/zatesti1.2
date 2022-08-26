<?php

namespace App\Services;

use NotificationChannels\Telegram\TelegramUpdates;
use App\Models\UserResponse;

class UserResponseService
{

    public function __construct(private UserResponse $userResponse){}

    /**
     * Функция для сохранения ответа пользователя
     * @return bool
     */
    public function saveUserResponse(){
        $userResponse = TelegramUpdates::create()->latest()->options(['timeout' => 0,])->get();

        $responseText = $userResponse['result'][0]['message']['text'];
        $responseMessageId = $userResponse['result'][0]['message']['message_id'];

        $saveResponseResult = $this->userResponse->saveUserResponse($responseText,$responseMessageId);

        return $saveResponseResult;
    }

}
