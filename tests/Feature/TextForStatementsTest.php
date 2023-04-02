<?php

namespace Tests\Feature;

use App\Exceptions\TextForStatementsIsNullException;
use App\Jobs\MakeStatementsFromTextForUser;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Models\User;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextForStatementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестируем создание текста, который далее будет разбит на высказывания. Сценарий, когда текст создается
     *
     * @return void
     */
    public function test_create_text_for_statements()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements/text',
            ['text' => "new text"],
            ["Accept"=>"application/json"]);


        $this->assertDatabaseHas('text', [
            'text' => "new text",
        ]);

    }

    /**
     * Тест для проверки того как выглядит ответ api при запросе на создание текста
     * @return void
     */
    public function test_create_text_for_statements_api_response(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements/text',
            ['text' => "new text"],
            ["Accept"=>"application/json"]);


        $response->assertJson(
            [
                "data" => [
                    "message" => "Text was added.",
                ]
            ]
        );
    }

    /**
     * Тест для проверки того что job для создания высказываний из текста был запущен
     * @return void
     */
    public function test_make_statements_from_text_job_dispatched(){
        $this->expectsJobs(MakeStatementsFromTextForUser::class);

        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/text/generate-statements');
    }


    /**
     * Тест для проверки функции на получение нераспарсенного текста пользователя
     * @return void
     * @throws TextForStatementsIsNullException
     */
    public function test_get_unparsed_text_for_user(){
        $user = User::factory()->create();

        $text = "Sentence1.Sentence2.Sentence3";

        $this->actingAs($user)->post('/api/statements/text',
            ['text' => $text],
            ["Accept"=>"application/json"]);

        $textForStatementsService = new TextForStatementsService();
        $unparsedText = $textForStatementsService->getUnparsedTextForUser($user->id);

        $this->assertSame($text, $unparsedText->text);
    }

    /**
     * Тест ответа api на создание высказываний из текста
     * @return void
     * @throws \App\Exceptions\NoStatementsException
     */
    public function test_make_statements_from_text_api_response(){

        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/statements/text',
            ['text' => "Sentence1.Sentence2.Sentence3"],
            ["Accept"=>"application/json"]);

        $result = $this->actingAs($user)->post('/api/text/generate-statements');

        $statementService = new StatementService();
        $statements = $statementService->getStatements($user->id)->pluck('text')->toArray();

        $this->assertSame(
            [
                0 => 'Sentence1',
                1 => 'Sentence2',
                2 => 'Sentence3'
            ],
            $statements
        );

        $result->assertJson(
            [
                "data" => [
                    "message" => "The text was divided into statements.",
                ]
            ]
        );
    }


    /**
     * Тест на то что текст, который был распарсен, был отмечен как распарсенный
     * @return void
     */
    public function test_whether_parsed_texts_were_marked(){

        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/statements/text',
            ['text' => "Sentence1.Sentence2.Sentence3"],
            ["Accept"=>"application/json"]);


        $this->actingAs($user)->post('/api/text/generate-statements');

        $parsedText = TextForStatements::where('is_parsed', 1)->first();

        $this->assertSame("Sentence1.Sentence2.Sentence3", $parsedText->text);

    }

}
