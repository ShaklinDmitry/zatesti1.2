<?php

namespace Tests\Feature\Statements;

use App\Models\User;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use Tests\TestCase;

class StatementRepositoryTest extends TestCase
{

    /**
     * @return void
     */
    public function test_create_statement()
    {
        $guid = uniqid();
        $user = User::factory()->create();
        $text = "test text";

        $statementRepository = new StatementRepository();
        $statementRepository->createStatement(guid: $guid, userId: $user->id, text: $text);

        $this->assertDatabaseHas("statement",
            ["text" => $text,
            "user_id" => $user->id]
        );
    }
}
