<?php

namespace Tests\Feature;

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

        dd($response);

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

}
