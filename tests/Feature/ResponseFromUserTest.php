<?php

namespace Tests\Feature;

use App\Classes\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Classes\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Classes\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Classes\TypesOfUserResponses\UnknownUserResponseType;
use App\Domains\GetTypeOfUserResponseCommand;
use App\Events\SendUserResponse;
use App\Http\Controllers\BestStatementController;
use App\Listeners\SaveUserResponse;
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
    use RefreshDatabase;

    /**
     * тест для сохранения ответа пользователя в телеграмме в таблицу user_response
     * @return void
     */
        public function test_save_user_response(){
            $telegram_chat_id = 1;
            $text = 'test text';

            //event
            $sendUserResponse = new SendUserResponse($telegram_chat_id, $text);

            User::factory()->create([
                'telegram_chat_id' => $telegram_chat_id
            ]);

            //listener
            $saveUserResponse = new SaveUserResponse();
            $saveUserResponse->handle($sendUserResponse);

            $this->assertDatabaseHas('user_response', [
               'text' => $text
            ]);

        }


    /**
     * тест на получение ответов пользователей на этой неделе
     * @return void
     * @throws \Exception
     */
        public function test_get_user_responses_for_this_week(){

            $telegram_chat_id = 1;

            $user = User::factory()->create([
                'telegram_chat_id' => $telegram_chat_id
            ]);

            $startOfWeek = now()->startOfWeek()->format('Y-m-d H:i');

            UserResponse::factory()->count(3)->create([
                'telegram_chat_id' => $telegram_chat_id,
                'text' => 'default text',
                'created_at' => $startOfWeek
            ]);

            $userResponseService = new UserResponseService();
            $userResponses = $userResponseService->getUserResponsesForThisWeek($user);

            $this->assertSame(3, count($userResponses));
        }


    /**
     * тест для того чтобы понимать какого типа приходят ответы от пользователя
     * @return void
     */
        public function test_get_type_of_response(){
            $getTypeOfUserResponse = new GetTypeOfUserResponseCommand();

            $text = '/addbest test of best statement';
            $typeOfUserResponse = $getTypeOfUserResponse->execute($text);
            $this->assertInstanceOf(AddBestStatementUserResponseType::class, $typeOfUserResponse);

            $text2 = '/addtext this mean add text';
            $typeOfUserResponse = $getTypeOfUserResponse->execute($text2);
            $this->assertInstanceOf(AddTextForStatementsUserResponseType::class, $typeOfUserResponse);


            $text3 = '/splittext';
            $typeOfUserResponse = $getTypeOfUserResponse->execute($text3);
            $this->assertInstanceOf(SplitTextOfStatementsUserResponseType::class, $typeOfUserResponse);

            $text4 = 'this some text alalalalala';
            $typeOfUserResponse = $getTypeOfUserResponse->execute($text4);
            $this->assertInstanceOf(UnknownUserResponseType::class, $typeOfUserResponse);
        }
}
