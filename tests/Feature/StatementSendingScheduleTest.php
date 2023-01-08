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
    public function test_Get_User_Ids_Who_Should_Be_Notified_At_The_Current_Time()
    {
        $this->artisan('migrate:fresh');

        $currentTime = date("H:i");

        StatementSendingSchedule::factory()->create([
            'user_id' => 1,
            'exact_time' => $currentTime
        ]);

        StatementSendingSchedule::factory()->create([
            'user_id' => 2,
            'exact_time' => $currentTime
        ]);

        $result = StatementSendingSchedule::factory()->create([
            'user_id' => 8,
            'exact_time' => '15:50'
        ]);


        $statementScheduleService = new StatementScheduleService();
        $userIds = $statementScheduleService->getUserIdsWhoShouldBeNotifiedAtTheCurrentTime($currentTime);

        $userIdsSame = [
            0 => [
                "user_id" => 1
            ],
            1 => [
                "user_id" => 2
            ]
        ];

        $this->assertEquals($userIds, $userIdsSame);

    }


    public function test_Get_User_Ids_Who_Should_Be_Notified_At_The_Current_Time_When_Users_Is_Null(){
        $this->expectExceptionMessage('There are no users who are scheduled to receive a statement notification');

        $this->artisan('migrate:fresh');

        $currentTime = date("H:i");

        $statementScheduleService = new StatementScheduleService();
        $userIds = $statementScheduleService->getUserIdsWhoShouldBeNotifiedAtTheCurrentTime($currentTime);
    }
}
