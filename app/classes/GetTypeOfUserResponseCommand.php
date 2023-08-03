<?php

namespace App\classes;

use App\classes\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\classes\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\classes\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\classes\TypesOfUserResponses\UnknownUserResponseType;

class GetTypeOfUserResponseCommand
{

    /**
     * Функция для получения типа ответа пользователя в зависимости какая команда им указана в начале
     * @param string $text
     * @return AddBestStatementUserResponseType|AddTextForStatementsUserResponseType|SplitTextOfStatementsUserResponseType|UnknownUserResponseType
     */
    public function execute(string $text){
        $addBestType = str_contains($text, '/addbest');

        if($addBestType){
            return new AddBestStatementUserResponseType();
        }

        $addTextType = str_contains($text, '/addtext');
        if($addTextType){
            return new AddTextForStatementsUserResponseType();
        }

        $splitTextType = str_contains($text, '/splittext');
        if($splitTextType){
            return new SplitTextOfStatementsUserResponseType();
        }

        return new UnknownUserResponseType();
    }

}
