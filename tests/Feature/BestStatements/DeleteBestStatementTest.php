<?php

namespace Tests\Feature\BestStatements;

use App\classes\BestStatements\DeleteBestStatementCommand;
use App\classes\BestStatements\Exceptions\NoBestStatementsToDeleteException;
use App\Models\BestStatement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteBestStatementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование удаления высказывания
     * @return void
     */
    public function test_delete_best_statement()
    {
        $text = "test text";

        $bestStatement = BestStatement::factory()->create(
            ["text" => $text]
        );

        $this->assertDatabaseHas('best_statements', [
            'text' => $text,
        ]);

        $deleteBestStatement = new DeleteBestStatementCommand();
        $deleteBestStatement->execute($bestStatement->id);

        $this->assertDatabaseMissing('best_statements', [
            'text' => $text,
        ]);
    }


    /**
     * Тестировать выбрасывание исключение в случае, когда при удалении не существует высказывание с указанным id
     * @return void
     * @throws NoBestStatementsToDeleteException
     */
    public function test_delete_best_statement_exception_thrown(){
        $this->expectException(NoBestStatementsToDeleteException::class);

        $deleteBestStatement = new DeleteBestStatementCommand();
        $deleteBestStatement->execute(0);
    }

    /**
     * Тестирую ответ api при успешном удалении лучшего высказывания
     * @return void
     */
    public function test_delete_best_statement_success_api_response(){
        $user = User::factory()->create();

        $bestStatement = BestStatement::factory()->create(
            ["text" => 'test']
        );

        $response = $this->actingAs($user)->delete('/api/beststatements/' . $bestStatement->id);

        $response->assertJson(
            [
                "data" => [
                    "message" => "Statement was deleted successfull."
                ]
            ]
        );
    }


    /**
     * Тестирую ответ api при неудачном удалении лучшего высказывания
     * @return void
     */
    public function test_delete_best_statement_failed_api_response(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/api/beststatements/1');

        $response->assertJson(
            [
                "error" => [
                    "message" => "Statement was not deleted."
                ]
            ]
        );
    }

}
