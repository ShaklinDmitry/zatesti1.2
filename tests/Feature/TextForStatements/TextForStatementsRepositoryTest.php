<?php

namespace Tests\Feature\TextForStatements;

use App\Models\TextForStatementsEloquent;
use App\Models\User;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Tests\TestCase;

class TextForStatementsRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mark_text_as_parsed()
    {
        $guid = uniqid();
        $user = User::factory()->create();
        $text = "Sentence1.Sentence2.Sentence3";

        $textForStatements = TextForStatementsEloquent::factory()->create(
            [
                'guid' => $guid,
                'text' => $text,
                'user_id' => $user->id,
            ]
        );

        $textForStatementsRepository = new TextForStatementsRepository();
        $textForStatementsRepository->markTextParsed($textForStatements->guid);

        $this->assertDatabaseHas("text",[
            "guid" => $guid,
            "is_parsed" => 1
        ]);
    }
}
