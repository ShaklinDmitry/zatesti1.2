<?php

namespace Tests\Feature\Statements;

use App\classes\Statements\StatementSentStatusUpdater;
use App\Models\StatementEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatementSentStatusUpdaterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * тест на то чтобы поменять статус того что высказывание уже было отправлено
     * @return void
     */
    public function test_set_statement_sent_status()
    {
        $currentTime = NOW();

        $statement = StatementEloquent::factory()->create(
            [
                'send_date_time' => $currentTime,
                'user_id' => 1
            ]
        );

        $statementSentStatusUpdater = new StatementSentStatusUpdater();
        $statementSentStatusUpdater->setSentStatusTrue($statement->id);

        $this->assertSame($currentTime, $statement->send_date_time);
    }
}
