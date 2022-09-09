<?php

namespace Tests\Feature;

use App\Http\Controllers\ResponsesFromUserController;
use App\Models\UserResponse;
use App\Services\UserResponseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use NotificationChannels\Telegram\TelegramUpdates;
use Tests\TestCase;
use App\DTO\UserResponseDTO;

class ResponseFromUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_save_response_from_user()
    {

        $stub = $this->createMock(TelegramUpdates::class);

        // Настроить заглушку.
        $stub->method('get')
            ->willReturn(array('resonseText' => 'this is response text',
                                'responseMessageId' => 9));

        $userResponse = new UserResponse();
        $userResponseService = new UserResponseService($userResponse);

        $userResponseData = new UserResponseDTO($stub->get()['resonseText'],$stub->get()['responseMessageId']);

        $saveResponseResult = $userResponseService->saveUserResponse($userResponseData);

        $this->assertSame($saveResponseResult, true);
    }
}
