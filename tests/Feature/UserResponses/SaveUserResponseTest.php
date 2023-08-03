<?php

namespace Tests\Feature\UserResponses;

use Tests\TestCase;

class SaveUserResponseTest extends TestCase
{
    /**
     * тест на создание ответа пользователя
     * @return void
     */
    public function test_save_user_response()
    {
        $chatID = 1;
        $text = 'test text';

        $userResponse = new UserResponse($chatID, $text);
        $userResponse->save();

        $this->assertDatabaseHas('user_response', [
            'text' => $text
        ]);
    }
}
