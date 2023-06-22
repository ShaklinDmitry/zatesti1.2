<?php

namespace Tests\Feature\TextForStatements;

use App\Commands\GetUnparsedTextForStatementsCommand;
use App\Exceptions\NoStatementsException;
use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatements;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUnparsedTextForStatementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест для проверки функции на получение нераспарсенного текста пользователя
     * @return void
     * @throws TextForStatementsIsNullException
     */
    public function test_get_unparsed_text_for_statements()
    {
        $user = User::factory()->create();

        $text = "Sentence1.Sentence2.Sentence3";

        TextForStatements::factory()->create(
            [
                'text' => $text,
                'user_id' => $user->id,
            ]
        );

        $getUnparsedTextForStatements = new GetUnparsedTextForStatementsCommand();
        $unparsedText = $getUnparsedTextForStatements->execute($user->id);

        $this->assertSame($text, $unparsedText->text);
    }

    /**
     * Тест для проверки функции на получение нераспарсенного текста пользователя , когда нераспарсенных текстов уже нет
     * @return void
     * @throws TextForStatementsIsNullException
     */
    public function test_get_unparsed_text_for_statements_false(){
        $this->expectException(TextForStatementsIsNullException::class);

        $user = User::factory()->create();

        $text = "Sentence1.Sentence2.Sentence3";

        TextForStatements::factory()->create(
            [
                'text' => $text,
                'user_id' => $user->id,
                'is_parsed' => 1
            ]
        );

        $getUnparsedTextForStatements = new GetUnparsedTextForStatementsCommand();
        $unparsedText = $getUnparsedTextForStatements->execute($user->id);
    }
}
