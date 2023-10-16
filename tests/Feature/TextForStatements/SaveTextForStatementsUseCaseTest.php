<?php

namespace Tests\Feature\TextForStatements;

use App\Models\User;
use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Tests\TestCase;

class SaveTextForStatementsUseCaseTest extends TestCase
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

        $textForStatementsService = new TextForStatementsService();

        $textForStatementsDTO = $textForStatementsService->saveText(userId: $user->id, text: $text, textForStatementsRepository: $textForStatementsRepository);

        $this->assertDatabaseHas('text', [
            'text' => $textForStatementsDTO->text,
        ]);
    }
}
