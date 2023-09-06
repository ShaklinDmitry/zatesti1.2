<?php

namespace Tests\Feature\BestStatements;

use App\Models\StatementEloquent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferStatementToBestStatementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест на функционал перемещаения высказывания в "лучшие" высказывания
     * @return void
     */
    public function test_transfer_statement_to_best_statement()
    {
        $user = User::factory()->create();

        $statement = StatementEloquent::factory()->create([
            'id' => 1,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->post('/api/statements/transfer-to-best-statements',
            ['statementId' => 1],
            ["Accept"=>"application/json"]);

        $this->assertDatabaseHas('best_statements',
        [
            'text' => $statement->text,
            'user_id' => $user->id
        ]);

        $response->assertJson(
            [
                "data" => [
                    "message" => "StatementEloquent " . $statement->id . " was transfered to best statements"
                ]
            ]
        );
    }
}
