<?php

namespace Tests\Feature\UserResponses;

use App\Modules\UserResponses\Domain\UserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\UnknownUserResponseType;
use Tests\TestCase;

class GetTypeOfUserResponseTest extends TestCase
{

    /**
     * тест для того чтобы понимать какого типа приходят ответы от пользователя
     * @return void
     */
    public function test_get_type_of_user_response()
    {
        $userResponseType = new UserResponseType();

        $text = '/addbest test of best statement';
        $typeOfUserResponse = $userResponseType->getUserResponseType($text);
        $this->assertInstanceOf(AddBestStatementUserResponseType::class, $typeOfUserResponse);

        $text2 = '/addtext this mean add text';
        $typeOfUserResponse = $userResponseType->getUserResponseType($text2);
        $this->assertInstanceOf(AddTextForStatementsUserResponseType::class, $typeOfUserResponse);


        $text3 = '/splittext';
        $typeOfUserResponse = $userResponseType->getUserResponseType($text3);
        $this->assertInstanceOf(SplitTextOfStatementsUserResponseType::class, $typeOfUserResponse);

        $text4 = 'this some text alalalalala';
        $typeOfUserResponse = $userResponseType->getUserResponseType($text4);
        $this->assertInstanceOf(UnknownUserResponseType::class, $typeOfUserResponse);
    }
}
