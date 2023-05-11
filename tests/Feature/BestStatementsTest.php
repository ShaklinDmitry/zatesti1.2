<?php

namespace Tests\Feature;

use App\Events\SendUserResponse;
use App\Listeners\SaveBestStatements;
use App\Listeners\SaveUserResponse;
use App\Models\Statement;
use App\Models\User;
use App\Models\UserResponse;
use App\Services\BestStatementService;
use Database\Factories\UserResponseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BestStatementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * тест для случая когда у пользорвателя нет высказываний
     * @return void
     */
//    public function test_throw_no_best_statements_exception(){
//
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)->get('api/beststatements');
//
//        $this->assertSame($response['error']['message'], 'there no best responses for this user');
//    }


    /**
     * Тест для удаления лучших высказываний
     * @return void
     */
    public function test_delete_best_statement(){
        $user = User::factory()->create();

        $userResponse = UserResponse::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, UserResponse::all());

        $this->actingAs($user)->delete('api/beststatements/'.$userResponse->id);

        $this->assertCount(0, UserResponse::all());
    }


    /**
     * Функция для теста сохранения лучшего высказывания
     * @return void
     */
    public function test_save_best_statement(){
        $telegram_chat_id = 1;
        $text = 'test text';

        //event
        $sendUserResponse = new SendUserResponse($telegram_chat_id, $text);

        $user = User::factory()->create([
            'telegram_chat_id' => $telegram_chat_id
        ]);

        //listener
        $saveBestStatement = new SaveBestStatements();
        $saveBestStatement->handle($sendUserResponse);

        $this->assertDatabaseHas('best_statements', [
            'text' => $text,
            'user_id' => $user->id
        ]);
    }

    /**
     * Тестирование получения лучших высказываний
     * @return void
     * @throws \Exception
     */
    public function test_get_best_statements(){
        $telegram_chat_id = 1;
        $text = 'test text';

        //event
        $sendUserResponse = new SendUserResponse($telegram_chat_id, $text);

        $user = User::factory()->create([
            'telegram_chat_id' => $telegram_chat_id
        ]);

        //listener
        $saveBestStatement = new SaveBestStatements();
        $saveBestStatement->handle($sendUserResponse);

        $bestStatementService = new BestStatementService();
        $bestStatement = $bestStatementService->getBestStatements($user->id);


        $this->assertSame('test text', $bestStatement[0]->text);
    }

    /**
     * Тестирование получения исключения при отсутствии лучших высказываний
     * @return void
     * @throws \Exception
     */
    public function test_get_best_statements_exception(){
        $this->expectExceptionMessage('there no best statements for this user');

        $bestStatementService = new BestStatementService();
        $bestStatement = $bestStatementService->getBestStatements(0);
    }
}
