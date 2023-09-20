<?php

namespace App\Modules\UserResponses;

use App\Modules\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Modules\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Modules\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Modules\TypesOfUserResponses\UnknownUserResponseType;

class UserResponseType
{
    /**
     * Функция для получения типа ответа пользователя в зависимости какая команда им указана в начале
     * @param string $text
     * @return AddBestStatementUserResponseType|AddTextForStatementsUserResponseType|SplitTextOfStatementsUserResponseType|UnknownUserResponseType
     */
    public function getUserResponseType(string $responseText){
        $addBestType = str_contains($responseText, AddBestStatementUserResponseType::TEXT);
        if($addBestType){
            return new AddBestStatementUserResponseType();
        }

        $addTextType = str_contains($responseText, AddTextForStatementsUserResponseType::TEXT);
        if($addTextType){
            return new AddTextForStatementsUserResponseType();
        }

        $splitTextType = str_contains($responseText, SplitTextOfStatementsUserResponseType::TEXT);
        if($splitTextType){
            return new SplitTextOfStatementsUserResponseType();
        }

        return new UnknownUserResponseType();
    }
}
