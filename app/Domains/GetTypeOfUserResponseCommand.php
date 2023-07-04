<?php

namespace App\Domains;

use App\Classes\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Classes\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Classes\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Classes\TypesOfUserResponses\UnknownUserResponseType;

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
