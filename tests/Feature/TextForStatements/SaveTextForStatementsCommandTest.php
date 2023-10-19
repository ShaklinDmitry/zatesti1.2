<?php

namespace Tests\Feature\TextForStatements;

use App\Models\User;
use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommand;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Tests\TestCase;

class SaveTextForStatementsCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_save_text_for_statements()
    {
        $user = User::factory()->create();
        $text = "test text";
        $textForStatementsRepository = new TextForStatementsRepository();

        $saveTextForStatementsCommand = new SaveTextForStatementsCommand($textForStatementsRepository);
        $textForStatementsDTO = $saveTextForStatementsCommand->execute(userId: $user->id, text: $text);

        $this->assertDatabaseHas('text', [
            'text' => $textForStatementsDTO->text,
        ]);
    }
}
