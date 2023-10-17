<?php

namespace Tests\Feature\TextForStatements;

use App\Models\TextForStatementsEloquent;
use App\Models\User;
use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Tests\TestCase;

class MakeStatementsFromTextUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_make_statements_from_text()
    {
        $user = User::factory()->create();
        $text = "Sentence1. Sentence2. Sentence3.";

        $textForStatement = TextForStatementsEloquent::factory()->create(
            [
                "text" => $text,
                "user_id" => $user->id
            ]
        );

        $textForStatementsRepository = new TextForStatementsRepository();
        $textForStatementsService = new TextForStatementsService();
        $textForStatementsService->makeStatementsFromText(userId: $user->id,textForStatementsRepository: $textForStatementsRepository);

        $this->assertDatabaseHas("statement", [
            'text' => "Sentence1",
        ]);

    }
}
