<?php

namespace App\Modules\UserResponses\Application;

use App\Modules\UserResponses\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\UnknownUserResponseType;

class GetUserResponseTypeUseCase
{
    public function __construct(private string $text)
    {
    }

    /**
     * @return AddBestStatementUserResponseType|AddTextForStatementsUserResponseType|SplitTextOfStatementsUserResponseType|UnknownUserResponseType
     */
    public function execute(){
        $addBestType = str_contains($this->text, '/addbest');

        if($addBestType){
            return new AddBestStatementUserResponseType();
        }

        $addTextType = str_contains($this->text, '/addtext');
        if($addTextType){
            return new AddTextForStatementsUserResponseType();
        }

        $splitTextType = str_contains($this->text, '/splittext');
        if($splitTextType){
            return new SplitTextOfStatementsUserResponseType();
        }

        return new UnknownUserResponseType();
    }

}
