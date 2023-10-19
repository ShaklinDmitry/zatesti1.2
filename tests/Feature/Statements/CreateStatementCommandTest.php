<?php

namespace Tests\Feature\Statements;

use App\Models\User;
use App\Modules\Statements\Application\UseCases\CreateStatementCommand;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use Tests\TestCase;

class CreateStatementCommandTest extends TestCase
{
    /**
     * @return void
     */
    public function test_create_statement_command()
    {
        $statementText = "test text";

        $user = User::factory()->create();

        $statementRepository = new StatementRepository();
        $createStatementCommand = new CreateStatementCommand(statementRepository: $statementRepository);

        $createStatementCommand->execute(userId: $user->id, text: $statementText);

        $this->assertDatabaseHas("statement", [
            "text" => $statementText
        ]);
    }
}
