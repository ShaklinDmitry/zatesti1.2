<?php

namespace Tests\Feature\TextForStatements;

use App\Commands\ParseTextIntoStatementsCommand;
use Tests\TestCase;

class ParseTextIntoStatementsTest extends TestCase
{
    /**
     * Функция для того чтобы разбить текст на высказывания
     * @return void
     */
    public function test_parse_text_into_statements()
    {
        $text = "Sentence1.Sentence2.Sentence3";

        $parseTextIntoStatements = new ParseTextIntoStatementsCommand();
        $result = $parseTextIntoStatements->execute($text);

        $this->assertSame([
            0 => "Sentence1",
            1 => "Sentence2",
            2 => "Sentence3"
        ], $result);
    }
}
