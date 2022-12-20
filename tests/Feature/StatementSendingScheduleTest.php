<?php

namespace Tests\Feature;

use App\Models\StatementSendingSchedule;
use App\Services\StatementScheduleService;
use Database\Factories\StatementSendingScheduleFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatementSendingScheduleTest extends TestCase
{
    /**
     * Тестируем поиск пользователей, которым в данное время нужно отправить высказывание
     *
     * @return void
     */
    public function test_statement_send_schedule()
    {
        $this->artisan('migrate:fresh');

        StatementSendingSchedule::factory()->create([
            'exact_time' => '14:00'
        ]);

        StatementSendingSchedule::factory()->create([
            'exact_time' => '14:00'
        ]);

        $result = StatementSendingSchedule::factory()->create([
            'exact_time' => '15:50'
        ]);

//        $t=time();
//
//        $currentTime = date("H:i",$t);
        $currentTime = '14:00';


        $statementScheduleService = new StatementScheduleService();
        $users = $statementScheduleService->getUsersWhoAccordingToTheScheduleShouldSendMessage($currentTime);

        $this->assertCount(2, $users);
    }
}
