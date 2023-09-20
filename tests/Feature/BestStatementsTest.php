<?php

namespace Tests\Feature;

use App\Events\UserResponseSended;
use App\Listeners\SaveBestStatements;
use App\Models\BestStatementEloquent;
use App\Models\User;
use App\Services\BestStatementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestStatementsTest extends TestCase
{
//
//    /**
//     * Тестирование получения лучших высказываний
//     * @return void
//     * @throws \Exception
//     */
//    public function test_get_best_statements(){
//        $telegram_chat_id = 1;
//        $text = 'test text';
//
//        //event
//        $sendUserResponse = new UserResponseSended($telegram_chat_id, $text);
//
//        $user = User::factory()->create([
//            'telegram_chat_id' => $telegram_chat_id
//        ]);
//
//        //listener
//        $saveBestStatement = new SaveBestStatements();
//        $saveBestStatement->handle($sendUserResponse);
//
//
////        $bestStatementService = new BestStatementService();
////        $bestStatement = $bestStatementService->getBestStatements($user->id);
//
//        $getBestStatements = new GetBestStatementsCommand();
//        $bestStatement = $getBestStatements->execute($user->id);
//
//        $this->assertSame('test text', $bestStatement[0]->text);
//    }
//
//    /**
//     * Тестирование получения исключения при отсутствии лучших высказываний
//     * @return void
//     * @throws \Exception
//     */
//    public function test_get_best_statements_exception(){
//        $this->expectExceptionMessage('there no best statements for this user');
//
//        $bestStatementService = new BestStatementService();
//        $bestStatement = $bestStatementService->getBestStatements(0);
//    }


    /**
     * Тест для того чтобы перед добавлением в очередь слушателя сохрарнения лучшего высказывания проверить тип ответа пользователя на необходимый. В данном случае /addbest
     * @return void
     */
//    public function test_save_best_statement_listener_should_queue(){
//        $telegram_chat_id = 1;
//        $text = '/addbest test text';
//
//        //event
//        $sendUserResponse = new UserResponseSended($telegram_chat_id, $text);
//
//        //listener
//        $saveBestStatement = new SaveBestStatements();
//        $shouldQueueResult = $saveBestStatement->shouldQueue($sendUserResponse);
//
//        $this->assertSame(true, $shouldQueueResult);
//    }
}
