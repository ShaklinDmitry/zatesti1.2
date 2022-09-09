<?php

namespace App\DTO;

/**
 * DTO класс для ответа пользователя на высказывания
 */
class UserResponseDTO
{
    public string $responseText;

    public int $responseMessageId;

    public function __construct($responseText, $responseMessageId){
        $this->responseText = $responseText;
        $this->responseMessageId = $responseMessageId;

        return $this;
    }
}
