<?php

namespace Tests\Feature\TextForStatements;

use App\classes\Text\MarkTextAsParsedCommand;
use App\Models\TextForStatementsEloquent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkTextAsParsedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест на то что текст, который был распарсен, был отмечен как распарсенный
     * @return void
     */
    public function test_mark_text_as_parsed()
    {
        $user = User::factory()->create();

        $text = "Sentence1.Sentence2.Sentence3";

        $textForStatements = TextForStatementsEloquent::factory()->create(
            [
                'text' => $text,
                'user_id' => $user->id,
            ]
        );

        $markTextAsParsed = new MarkTextAsParsedCommand();
        $markTextAsParsed->execute($textForStatements->id);

        $this->assertSame(1, TextForStatementsEloquent::find($textForStatements->id)->is_parsed);
    }
}
