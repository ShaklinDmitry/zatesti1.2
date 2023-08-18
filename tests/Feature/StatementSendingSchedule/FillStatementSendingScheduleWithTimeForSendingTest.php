<?php

namespace Tests\Feature\StatementSendingSchedule;

use App\Models\StatementSendingSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FillStatementSendingScheduleWithTimeForSendingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест для заполнения таблицы с расписанием
     * @return void
     */
    public function test_fill_statement_sending_schedule_with_time_for_sending()
    {
        $times = "13:15;15:55";
        $userId = 1;

        $statementSendingSchedule = new StatementSendingSchedule();
        $statementSendingSchedule->fillWithTimeForSending($times, $userId);

        $this->assertDatabaseHas('send_statements_schedule',[
            'exact_time' => '13:15',
            'user_id' => $userId
        ]);
        $this->assertDatabaseHas('send_statements_schedule',[
            'exact_time' => '15:55',
            'user_id' => $userId
        ]);
    }
}
