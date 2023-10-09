<?php

namespace App\Modules\UserResponses\Domain;

use App\Modules\UserResponses\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\UnknownUserResponseType;
use function App\Modules\UserResponses\str_contains;

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
