<?php


use App\Models\User;
use App\Modules\Statements\AddStatementCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddStatementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование функционала добавления нового высказыания
     *
     * @return void
     */
    public function test_add_statement()
    {
        $user = User::factory()->create();

        $text = "test text";

        $addStatement = new AddStatementCommand();
        $addStatement->execute($text, $user->id);

        $this->assertDatabaseHas('statement', [
            'text' => "test text",
        ]);
    }
}
