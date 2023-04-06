<?php

namespace Tests\Feature;

use App\Http\Controllers\BestStatementController;
use App\Models\User;
use App\Models\UserResponse;
use App\Services\UserResponseService;
use Database\Factories\UserResponseFactory;
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
//    public function test_save_response_from_user()
//    {
//
//        $stub = $this->createMock(TelegramUpdates::class);
//
//        // Настроить заглушку.
//        $stub->method('get')
//            ->willReturn(array('resonseText' => 'this is response text',
//                                'responseMessageId' => 9));
//
//        $userResponse = new UserResponse();
//        $userResponseService = new UserResponseService($userResponse);
//
//        $userResponseData = new UserResponseDTO($stub->get()['resonseText'],$stub->get()['responseMessageId']);
//
//        $saveResponseResult = $userResponseService->saveUserResponse($userResponseData);
//
//        $this->assertSame($saveResponseResult, true);
//    }

    /**
     * тест на получение ответов пользователей на этой неделе
     * @return void
     * @throws \Exception
     */
        public function test_get_user_responses_for_this_week(){
            $this->artisan('migrate:fresh');

            $telegram_chat_id = 1111;

            $user = User::factory()->create([
                'telegram_chat_id' => $telegram_chat_id
            ]);

            $yesterdayDate = date('Y-m-d H:i',strtotime("-1 days"));

            UserResponse::factory()->count(3)->create([
                'telegram_chat_id' => $telegram_chat_id,
                'text' => 'default text',
                'created_at' => $yesterdayDate
            ]);

            $userResponseService = new UserResponseService();
            $userResponses = $userResponseService->getUserResponsesForThisWeek($user);

            $this->assertSame(3, count($userResponses));
        }

    /**
     * тест на получение ответов пользователей на этой неделе, если ответов не было
     * @return void
     * @throws \Exception
     */
//        public function test_get_user_responses_for_this_week_if_there_is_no_responses(){
//            $this->expectExceptionMessage('No user responses this week');
//
//            $this->artisan('migrate:fresh');
//
//            $telegram_chat_id = 1111;
//
//            $user = User::factory()->create([
//                'telegram_chat_id' => $telegram_chat_id
//            ]);
//
//            $userResponseService = new UserResponseService();
//            $userResponses = $userResponseService->getUserResponsesForThisWeek($user);
//        }
}
