<?php

namespace Tests\Feature;

use App\Events\SendUserResponse;
use App\Listeners\SaveBestStatements;
use App\Listeners\SaveUserResponse;
use App\Models\BestStatement;
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
     * Тест для удаления лучших высказываний
     * @return void
     */
    public function test_delete_best_statement(){
        $user = User::factory()->create();

        $bestStatement = BestStatement::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->delete('api/beststatements/'.$bestStatement->id);

        $this->assertCount(0, BestStatement::all());
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


    /**
     * Тест для того чтобы перед добавлением в очередь слушателя сохрарнения лучшего высказывания проверить тип ответа пользователя на необходимый. В данном случае /addbest
     * @return void
     */
    public function test_save_best_statement_listener_should_queue(){
        $telegram_chat_id = 1;
        $text = '/addbest test text';

        //event
        $sendUserResponse = new SendUserResponse($telegram_chat_id, $text);

        //listener
        $saveBestStatement = new SaveBestStatements();
        $shouldQueueResult = $saveBestStatement->shouldQueue($sendUserResponse);

        $this->assertSame(true, $shouldQueueResult);
    }
}
