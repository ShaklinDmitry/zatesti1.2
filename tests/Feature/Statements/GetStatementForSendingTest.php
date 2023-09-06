<?php

namespace Tests\Feature\Statements;

use App\classes\Statements\GetStatementForSendingCommand;
use App\Exceptions\NoStatementsForSendingException;
use App\Models\StatementEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetStatementForSendingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование функционала на получение сообщений для отправки.
     * @return void
     */
    public function test_get_statement_for_sending_test()
    {
        $userId = 1;
        $text = 'test text';

        $statement = StatementEloquent::factory()->create(
            [
                'user_id' => $userId,
                'text' => $text
            ]
        );

        $getStatementForSending = new GetStatementForSendingCommand($userId);
        $statementForSending = $getStatementForSending->execute();

        $this->assertSame($text, $statementForSending->text);

    }

    /**
     * Тестирование функционала на получение сообщений для отправки. Случай когда нет сообщений, которые нужно отправлять
     * @return void
     * @throws NoStatementsForSendingException
     */
    public function test_get_statement_for_sending_exception_test(){
        $this->expectException(NoStatementsForSendingException::class);

        $userId = 1;

        $getStatementForSending = new GetStatementForSendingCommand($userId);
        $statementForSending = $getStatementForSending->execute();
    }
}
