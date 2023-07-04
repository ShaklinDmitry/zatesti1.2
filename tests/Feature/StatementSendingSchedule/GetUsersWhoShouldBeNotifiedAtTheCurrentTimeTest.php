<?php

namespace Tests\Feature\StatementSendingSchedule;

use App\Domains\StatementSendingSchedule\Exception\NoUsersWhoScheduledToReceiveStatementNotificationException;
use App\Domains\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand;
use App\Models\StatementSendingSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUsersWhoShouldBeNotifiedAtTheCurrentTimeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестируем поиск пользователей, которым в данное время нужно отправить высказывание. Случай когда пользователь один на указанное время
     * @return void
     * @throws \Exception
     */
    public function test_get_single_users_who_should_be_notified_at_the_current_time()
    {
        $currentTime = date("H:i");

        $userFirst = User::factory()->create(
            ['id' => 1]
        );

        StatementSendingSchedule::factory()->create([
            'user_id' => $userFirst,
            'exact_time' => $currentTime
        ]);


        $getUserIdsWhoShouldBeNotifiedAtTheCurrentTime = new GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand($currentTime);
        $users = $getUserIdsWhoShouldBeNotifiedAtTheCurrentTime->execute();


        $this->assertDatabaseHas('send_statements_schedule', [
            'exact_time' => $currentTime,
            'user_id' => $users[0]->id
        ]);

    }

    /**
     * Тестируем поиск пользователей, которым в данное время нужно отправить высказывание. Случай когда пользователей несколько на указанное время
     * @return void
     * @throws \Exception
     */
    public function test_get_multiple_users_who_should_be_notified_at_the_current_time()
    {
        $currentTime = date("H:i");

        $userFirst = User::factory()->create(
            ['id' => 1]
        );

        $userSecond = User::factory()->create(
            ['id' => 2]
        );

        StatementSendingSchedule::factory()->create([
            'user_id' => $userFirst,
            'exact_time' => $currentTime
        ]);

        StatementSendingSchedule::factory()->create([
            'user_id' => $userSecond,
            'exact_time' => $currentTime
        ]);

        StatementSendingSchedule::factory()->create([
            'user_id' => 8,
            'exact_time' => '15:50'
        ]);

        $getUserIdsWhoShouldBeNotifiedAtTheCurrentTime = new GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand($currentTime);
        $users = $getUserIdsWhoShouldBeNotifiedAtTheCurrentTime->execute();


        $this->assertDatabaseHas('send_statements_schedule', [
            'exact_time' => $currentTime,
            'user_id' => $users[0]->id
        ]);

        $this->assertDatabaseHas('send_statements_schedule', [
            'exact_time' => $currentTime,
            'user_id' => $users[1]->id
        ]);
    }

    /**
     * Для тестирования выброса исключения в случае когда нет пользователей на указанное время
     * @return void
     * @throws \Exception
     */
    public function test_get_users_who_should_be_notified_at_the_current_time_exception(){
        $currentTime = date("H:i");

        $this->expectException(NoUsersWhoScheduledToReceiveStatementNotificationException::class);

        $getUserIdsWhoShouldBeNotifiedAtTheCurrentTime = new GetUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand($currentTime);
        $users = $getUserIdsWhoShouldBeNotifiedAtTheCurrentTime->execute();
    }
}

