<?php

namespace App\Modules;

use App\Modules\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Modules\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Modules\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Modules\TypesOfUserResponses\UnknownUserResponseType;

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
