<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatementTest extends TestCase
{
    /**
     * Тестирование создания высказывания
     *
     * @return void
     */
    public function test_correct_create_statement()
    {
        $response = $this->post('/api/statements',
                                    ['text' => "new statement"]);

        $response->assertJson(
            ["data" => [
                "message" => "Statement was create successfull."
                       ]
                ]
            );
    }

    /**
     * Тестирование неудачного создания высказывания, когда при создании требуемого поля нет
     *
     * @return void
     */
    public function test_failed_create_statement(){
        $response = $this->post('/api/statements',
            ['wrongField' => "new statement"]);

        $response->assertJson(
            ["error" => [
                "message" => "Statement not created."
            ]
            ]
        );
    }


    /**
     * Тестирование получения списка высказываний
     *
     * @return void
     */
    public function test_get_statements(){
        $this->artisan('migrate:fresh');

         $this->post('/api/statements',
            ['text' => "test statement"]);

        $response = $this->get('/api/statements');

        $response->assertJson(
            [
                "data" => [
                    "statements" => [
                        array(
                            'text' => 'test statement',
                        )]
                ]
            ]
        );

    //    dd($response);

    }


}
