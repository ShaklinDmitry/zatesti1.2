<?php

namespace Tests\Feature\StatementSendingSchedule;

use App\classes\StatementSendingSchedule\Exception\NoUsersForWeeklyNotificationsException;
use App\classes\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedThisWeekCommand;
use App\classes\StatementSendingSchedule\Models\StatementSendingSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUsersWhoShouldBeNotifiedThisWeekTest extends TestCase
{

    use RefreshDatabase;

    /**
     * тестируем поиск пользователей, которым нужно отправить недельный отчет по высказываниям
     * @return void
     * @throws NoUsersForWeeklyNotificationsException
     */
    public function test_get_single_user_who_should_be_notified_this_week(){
        $currentTime = date("H:i");

        User::factory()->create(
            ['id' => 1]
        );

        StatementSendingSchedule::factory()->create([
            'user_id' => 1,
            'exact_time' => $currentTime
        ]);

        $getUsersWhoShouldBeNotifiedThisWeek = new GetUsersWhoShouldBeNotifiedThisWeekCommand();
        $users = $getUsersWhoShouldBeNotifiedThisWeek->execute();

        $this->assertDatabaseHas('send_statements_schedule', [
            'exact_time' => $currentTime,
            'user_id' => $users[0]->id
        ]);

    }


    /**
     * тестируем поиск пользователей, которым нужно отправить недельный отчет по высказываниям
     * @return void
     * @throws NoUsersForWeeklyNotificationsException
     */
    public function test_get_multiple_users_who_should_be_notified_this_week()
    {
        $currentTime = date("H:i");

        User::factory()->create(
            [
                'id' => 1
            ]
        );
        User::factory()->create(
            [
                'id' => 3
            ]
        );


        StatementSendingSchedule::factory()->create([
            'user_id' => 1,
            'exact_time' => $currentTime
        ]);

        StatementSendingSchedule::factory()->create([
            'user_id' => 3,
            'exact_time' => $currentTime
        ]);

        $getUsersWhoShouldBeNotifiedThisWeek = new GetUsersWhoShouldBeNotifiedThisWeekCommand();
        $users = $getUsersWhoShouldBeNotifiedThisWeek->execute();

        $this->assertDatabaseHas('send_statements_schedule', [
            'exact_time' => $currentTime,
            'user_id' => $users[0]->id
        ]);

        $this->assertDatabaseHas('send_statements_schedule', [
            'exact_time' => $currentTime,
            'user_id' => $users[0]->id
        ]);
    }

    /**
     *
     * @return void
     * @throws NoUsersForWeeklyNotificationsException
     */
    public function test_get_users_who_should_be_notified_this_week_exception(){
        $this->expectException(NoUsersForWeeklyNotificationsException::class);

        $getUsersWhoShouldBeNotifiedThisWeek = new GetUsersWhoShouldBeNotifiedThisWeekCommand();
        $users = $getUsersWhoShouldBeNotifiedThisWeek->execute();
    }
}
