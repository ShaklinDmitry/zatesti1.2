<?php

namespace Tests\Feature\TextForStatements;

use App\Domains\Text\MarkTextAsParsedCommand;
use App\Models\TextForStatements;
use App\Models\User;
use Tests\TestCase;

class MarkTextAsParsedTest extends TestCase
{
    /**
     * Тест на то что текст, который был распарсен, был отмечен как распарсенный
     * @return void
     */
    public function test_mark_text_as_parsed()
    {
        $user = User::factory()->create();

        $text = "Sentence1.Sentence2.Sentence3";

        $textForStatements = TextForStatements::factory()->create(
            [
                'text' => $text,
                'user_id' => $user->id,
            ]
        );

        $markTextAsParsed = new MarkTextAsParsedCommand();
        $markTextAsParsed->execute($textForStatements->id);

        $this->assertSame(1, TextForStatements::find($textForStatements->id)->is_parsed);
    }
}
