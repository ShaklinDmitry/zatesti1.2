<?php

namespace Tests\Feature\Statements;

use App\Models\Statement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteStatementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Тест для удаления высказываний
     * @return void
     */
    public function test_delete_statement()
    {
        $user = User::factory()->create();
        $text = "test text";

        $statement = Statement::factory()->create(
            [
                'user_id' => $user->id,
                'text' => $text
            ]
        );

        $this->assertDatabaseHas('statement',
        [
            'text' => $text,
        ]);

        $request = $this->actingAs($user)->delete('/api/statements/'.$statement->id);

        $this->assertDatabaseMissing('statement',
            [
                'user_id' => $user->id,
                'text' => $text
            ]
        );

        $request->assertJson(
            [
                "data" => [
                    "message" => "Statement was deleted."
                ]
            ]
        );

    }

}
