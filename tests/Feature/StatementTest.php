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
                "message" => [ '0' => "The text of the statement is missing in the request. Unable to create statement."]
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
    }

    /**
     * Тестирование удачного удаления высказывания
     *
     * @return void
     */
    public function test_success_delete_statement(){
        $this->artisan('migrate:fresh');

        $this->post('/api/statements',
            ['text' => "test statement"]);

        $getStatementsResponse = $this->get('/api/statements');

        $id  = $getStatementsResponse['data']['statements'][0]['id'];

        $deleteResponse = $this->delete('/api/statements',
                            ['id' => $id]);

        $deleteResponse->assertJson(
            ["data" => [
                "message" => "Statement was deleted."
                ]
            ]
        );

    }


    /**
     * Тестирование неудачного удаления высказывания
     *
     * @return void
     */
    public function test_failed_delete_statement(){
        $this->artisan('migrate:fresh');

        $deleteResponse = $this->delete('/api/statements',
            ['id' => -1]);

        $deleteResponse->assertJson(
            ["error" => [
                "message" => "Statement not deleted."
            ]
            ]
        );

    }




}
