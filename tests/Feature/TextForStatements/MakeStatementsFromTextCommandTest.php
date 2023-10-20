<?php

namespace Tests\Feature\TextForStatements;

use App\Models\TextForStatementsEloquent;
use App\Models\User;
use App\Modules\Statements\Application\UseCases\CreateStatementCommand;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommand;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeStatementsFromTextCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_make_statements_from_text()
    {
        $user = User::factory()->create();
        $text = "Sentence1.Sentence2.Sentence3.";

        $textForStatement = TextForStatementsEloquent::factory()->create(
            [
                "text" => $text,
                "user_id" => $user->id
            ]
        );

        $textForStatementsRepository = new TextForStatementsRepository();

        $statementRepository = new StatementRepository();
        $createStatementCommand = new CreateStatementCommand($statementRepository);

        $makeStatementsFromTextCommand = new MakeStatementsFromTextCommand($textForStatementsRepository, $createStatementCommand);
        $makeStatementsFromTextCommand->execute(userId: $user->id);

        $this->assertDatabaseHas("statement", [
            'text' => "Sentence1",
        ]);
        $this->assertDatabaseHas("statement", [
            'text' => "Sentence2",
        ]);
        $this->assertDatabaseHas("statement", [
            'text' => "Sentence3",
        ]);

    }
}
