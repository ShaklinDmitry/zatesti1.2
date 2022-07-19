<?php

namespace Tests\Feature;

use App\Services\TextForStatementsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextForStatementsTest extends TestCase
{
    /**
     * Тестируем создание текста, который далее будет разбит на высказывания. Сценарий, когда текст создается
     *
     * @return void
     */
    public function test_create_text_for_split_into_statements_true()
    {
        $this->artisan('migrate:fresh');

        $response = $this->post('/api/statements/text',
            ['text' => "new statement"]);

        $response->assertJson(
            [
                "data" => [
                    "message" => "Text was added.",
                ]
            ]
        );
    }

    /**
     * Тестируем создание текста, который далее будет разбит на высказывания. Сценарий, когда создание текста не происходит
     *
     * @return void
     */
    public function test_create_text_for_split_into_statements_false(){
        $this->artisan('migrate:fresh');

        //специально шлю не тот параметр text123 вместо text
        $response = $this->post('/api/statements/text',
            ['text123' => "new statement"]);

        $response->assertJson(
            [
                "error" => [
                    "message" => "Text was not added."
                ]
            ]
        );

    }

    public function test_get_statements_from_text(){
        $this->artisan('migrate:fresh');

//        $this->post('/api/statements/text',
//            ['text' => "Sentence number1. Sentence number 2. Sentence number 3."]);

        $this->post('/api/statements/text',
            ['text' => ""]);

        $textForStatementsService = new TextForStatementsService();
        $statements = $textForStatementsService->getStatements();

        dd($statements);

        $this->assertEquals(
            3,
            count($statements) - 1,
            "there must be 3 sentences"
        );

    }

}
