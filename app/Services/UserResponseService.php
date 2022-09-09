<?php

namespace App\Services;

use App\DTO\UserResponseDTO;
use NotificationChannels\Telegram\TelegramUpdates;
use App\Models\UserResponse;

class UserResponseService
{

    public function __construct(private UserResponse $userResponse){}

    /**
     * Функция для сохранения ответа пользователя
     * @return bool
     */
    public function saveUserResponse(UserResponseDTO $userResponseData){
        $this->userResponse->text = $userResponseData->responseText;
        $this->userResponse->message_id = $userResponseData->responseMessageId;

        $saveResponseResult = $this->userResponse->save();

        return $saveResponseResult;
    }

}
