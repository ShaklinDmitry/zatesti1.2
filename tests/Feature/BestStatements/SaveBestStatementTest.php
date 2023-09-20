<?php

namespace Tests\Feature\BestStatements;

use App\Modules\BestStatements\SaveBestStatementCommand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaveBestStatementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_save_best_statement()
    {
        $text = "test text";
        $chatId = 1;

        $user = User::factory()->create(
          [
              "telegram_chat_id" => $chatId
          ]
        );

        $saveBestStatement = new SaveBestStatementCommand();
        $saveBestStatement->execute($chatId, $text);

        $this->assertDatabaseHas('best_statements', [
            'text' => $text,
            'user_id' => $user->id
        ]);
    }
}
