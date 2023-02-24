<?php

namespace Tests\Feature;

use App\Exceptions\NoStatementsException;
use App\Models\User;
use App\Services\StatementService;
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
    public function test_successful_create_statement()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements',
                                    ['text' => "new statement"],
                                    ["Accept"=>"application/json"]);

        $this->assertDatabaseHas('statement', [
            'text' => "new statement",
        ]);

    }

    /**
     * Тестирование неудачного создания высказывания, когда при создании требуемого поля нет
     *
     * @return void
     */
    public function test_failed_create_statement(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements',
            ['wrongField' => "new statement"],
            ["Accept"=>"application/json"]);

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
    public function test_get_statements_response_successful(){
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/statements',
            ['text' => "test statement"],
            ["Accept"=>"application/json"]);

        $response = $this->actingAs($user)->get('/api/statements');

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
     * Тестирование выбрасывания исключения при отсутствии высказываний в БД
     * @return void
     * @throws NoStatementsException
     */
    public function test_get_statements_function_unsuccessful(){
        $this->expectException(NoStatementsException::class);

        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $statementService = new StatementService();
        $statementService->getStatements($user->id);
    }

    /**
     * тестирование того как выглядит ответ при get запросе на получение высказываний, когда их в базе нет
     * @return void
     */
    public function test_get_statements_api_response_unsuccessful(){

        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/statements');

        $response->assertJson(
            [
                "error" => [
                            'message' => 'No statements'
                ]
            ]
        );
    }

    /**
     * Тестирование удачного удаления высказывания
     *
     * @return void
     */
//    public function test_success_delete_statement(){
//        $this->artisan('migrate:fresh');
//
//        $user = User::factory()->create();
//
//        $this->actingAs($user)->post('/api/statements',
//            ['text' => "test statement"],
//        ["Accept"=>"application/json"]);
//
//        $getStatementsResponse = $this->actingAs($user)->get('/api/statements');
//
//        $id  = $getStatementsResponse['data']['statements'][0]['id'];
//
//        $deleteResponse = $this->delete('/api/statements',
//                            ['id' => $id]);
//
//        $deleteResponse->assertJson(
//            ["data" => [
//                "message" => "Statement was deleted."
//                ]
//            ]
//        );
//
//    }


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
