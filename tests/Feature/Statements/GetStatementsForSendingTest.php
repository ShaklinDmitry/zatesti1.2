<?php

namespace Tests\Feature\Statements;

use App\Models\StatementEloquent;
use App\Models\User;
use App\Modules\Statements\Application\UseCases\GetStatementForSendingCommandInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetStatementsForSendingTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_statements_for_sending()
    {
        $user = User::factory()->create();
        $testText = "test text";

        $statement = StatementEloquent::factory()->create(
            [
                'guid' => uniqid(),
                'user_id' => $user->id,
                'text' => $testText,
            ]
        );

        $getStatementForSendingCommand = app(GetStatementForSendingCommandInterface::class);
        $statementForSendingDTO = $getStatementForSendingCommand->execute($user->id);

        $this->assertSame($statementForSendingDTO->guid, $statement->guid);
    }
}
