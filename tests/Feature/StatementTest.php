<?php

namespace Tests\Feature;

use App\Exceptions\NoStatementsException;
use App\Models\Statement;
use App\Models\User;
use App\Services\StatementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatementTest extends TestCase
{
    use RefreshDatabase;

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

        $user = User::factory()->create();

        $statementService = new StatementService();
        $statementService->getStatements($user->id);
    }

    /**
     * тестирование того как выглядит ответ при get запросе на получение высказываний, когда их в базе нет
     * @return void
     */
    public function test_get_statements_api_response_unsuccessful(){

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
    public function test_success_delete_statement(){

        $user = User::factory()->create();

        $statement = Statement::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, Statement::all());

        $this->actingAs($user)->delete('/api/statements/'.$statement->id);

        $this->assertCount(0, Statement::all());

    }


    /**
     * Тест для переноса высказывания из категории "обычных" в категорию "лучших"
     * @return void
     */
    public function test_transfer_statement_to_best_statements(){
        $user = User::factory()->create();
        $statement = Statement::factory()->create(['user_id' => $user->id]);

        $statementService = new StatementService();
        $statementService->transferStatementToBestStatements($statement);

        $this->assertDatabaseHas('best_statements', [
            'text' => $statement->text
        ]);
    }

    /**
     * тест для проверки ответа api при переводе типа высказываний с обычного на "лучшее"
     * @return void
     */
    public function test_successful_transfer_statement_to_best_statements_api_response(){
        $user = User::factory()->create();
        $statement = Statement::factory()->create(['user_id' => $user->id]);

        $transferStatementResponse = $this->actingAs($user)->post('/api/statements/transfer-to-best-statements',
                                                ['statementId' => $statement->id]);

        $transferStatementResponse->assertJson(
            [
                "data" => [
                    "message" => 'Statement ' . $statement->id . ' was transfered to best statements',
                ]
            ]
        );
    }
}
