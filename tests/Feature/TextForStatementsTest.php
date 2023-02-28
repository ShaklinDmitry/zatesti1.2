<?php

namespace Tests\Feature;

use App\Exceptions\TextForStatementsIsNullException;
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


    public function test_make_statements_from_text(){

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


    public function test_whether_parsed_texts_were_marked(){

        $user = User::factory()->create();

       $result = $this->actingAs($user)->post('/api/statements/text',
            ['text' => "Sentence1.Sentence2.Sentence3"],
            ["Accept"=>"application/json"]);


        $result = $this->actingAs($user)->post('/api/text/generate-statements',[],["Accept"=>"application/json"]);

        $parsedText = TextForStatements::where('is_parsed', 1)->first();

        $this->assertNotNull($parsedText);

    }

}
