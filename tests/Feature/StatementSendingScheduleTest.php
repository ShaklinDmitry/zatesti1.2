<?php

namespace Tests\Feature;

use Tests\TestCase;


class StatementSendingScheduleTest extends TestCase
{
    /**
     * Тестируем поиск пользователей, которым в данное время нужно отправить высказывание
     *
     * @return void
     */
//    public function test_Get_User_Ids_Who_Should_Be_Notified_At_The_Current_Time()
//    {
//        $this->artisan('migrate:fresh');
//
//        $currentTime = date("H:i");
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 1,
//            'exact_time' => $currentTime
//        ]);
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 2,
//            'exact_time' => $currentTime
//        ]);
//
//        $result = StatementSendingSchedule::factory()->create([
//            'user_id' => 8,
//            'exact_time' => '15:50'
//        ]);
//
//
//        $statementScheduleService = new StatementScheduleService();
//        $users = $statementScheduleService->getUserIdsWhoShouldBeNotifiedAtTheCurrentTime($currentTime);
//
//
//        $this->assertEquals(2, count($users));
//    }

    /**
     * тестируется поиск пользовтелей, которым нужно отправить высказывания. Рассматривается случай когда на пользователя нет расписания
     * @return void
     * @throws \Exception
     */
//    public function test_Get_User_Ids_Who_Should_Be_Notified_At_The_Current_Time_When_Users_Is_Null(){
//        $this->expectExceptionMessage('There are no users who are scheduled to receive a statement notification');
//
//        $this->artisan('migrate:fresh');
//
//        $currentTime = date("H:i");
//
//        $statementScheduleService = new StatementScheduleService();
//        $users = $statementScheduleService->getUserIdsWhoShouldBeNotifiedAtTheCurrentTime($currentTime);
//    }

//    /**
//     * тестируем поиск пользователей, которым нужно отправить недельный отчет по высказываниям
//     * @return void
//     * @throws \Exception
//     */
//    public function test_get_users_who_should_be_notified_this_week(){
//        $this->artisan('migrate:fresh');
//
//        $currentTime = date("H:i");
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 1,
//            'exact_time' => $currentTime
//        ]);
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 1,
//            'exact_time' => '15:50'
//        ]);
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 3,
//            'exact_time' => $currentTime
//        ]);
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 5,
//            'exact_time' => $currentTime
//        ]);
//
//        $statementScheduleService = new StatementScheduleService();
//        $users = $statementScheduleService->getUsersWhoShouldBeNotifiedThisWeek();
//
//        $this->assertSame(3, count($users));
//    }

    /**
     * тестируем поиск пользователей, которым нужно отправить недельный отчет по высказываниям в случае если расписание пустое
     * @return void
     * @throws \Exception
     */
//    public function test_get_users_who_should_be_notified_this_week_if_schedule_is_empty(){
//        $this->expectExceptionMessage('No users for weekly notifications');
//
//        $this->artisan('migrate:fresh');
//
//        $statementScheduleService = new StatementScheduleService();
//        $users = $statementScheduleService->getUsersWhoShouldBeNotifiedThisWeek();
//
//    }

    /**
     * Тест для отправки в очередь для отправки уведомления
     * @return void
     * @throws \Exception
     */
//    public function test_send_statement_job_dispatched(){
//        Bus::fake();
//
//        $this->artisan('migrate:fresh');
//
//        $currentTime = date("H:i");
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 1,
//            'exact_time' => $currentTime
//        ]);
//
//        $telegramNotification = new TelegramNotificationSystem();
//
//        $statementService = new StatementService();
//        $statementService->sendStatements($currentTime, $telegramNotification);
//
//        Bus::assertDispatched(SendStatements::class);
//    }
}
