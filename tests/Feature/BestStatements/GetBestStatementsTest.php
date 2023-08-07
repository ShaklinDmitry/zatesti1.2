<?php

namespace Tests\Feature\BestStatements;

use App\classes\BestStatements\Exceptions\NoBestStatementsForUserException;
use App\classes\BestStatements\GetBestStatementsCommand;
use App\Models\BestStatement;
use App\Services\BestStatementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBestStatementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование получения лучших высказываний
     * @return void
     * @throws \Exception
     */
    public function test_get_best_statements()
    {
        $userId = 1;

        BestStatement::factory()->count(2)->sequence(
                ["text" => "text1"],
                ["text" => "text2"]
        )->create(
            ['user_id' => $userId]
        );

        $getBestStatements = new GetBestStatementsCommand();
        $bestStatement = $getBestStatements->execute($userId);

        $this->assertSame('text1', $bestStatement[0]->text);
        $this->assertSame('text2', $bestStatement[1]->text);
    }


    /**
     * Тестирование получения исключения при отсутствии лучших высказываний у пользователя
     * @return void
     * @throws \Exception
     */
    public function test_get_best_statements_exception(){
        $this->expectException(NoBestStatementsForUserException::class);

        $getBestStatements = new GetBestStatementsCommand();
        $bestStatements = $getBestStatements->execute(0);
    }
}
