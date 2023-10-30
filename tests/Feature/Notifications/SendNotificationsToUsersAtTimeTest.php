<?php

namespace Tests\Feature\Notifications;

use App\Models\StatementSendingSchedule;
use App\Models\TextForStatementsEloquent;
use App\Models\User;
use App\Modules\Notifications\Infrastructure\Notifications\TelegramNotification;
use App\Modules\StatementNotifications\Application\UseCases\SendNotificationsToUsersAtTimeCommand;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNotificationsToUsersAtTimeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_notifications_to_users_at_time()
    {

        $currentTime = date("H:i");

        $userFirst = User::factory()->create();
        $userSecond = User::factory()->create();

        $firstStatementSendingSchedule = StatementSendingSchedule::factory()->create([
            "guid" => uniqid(),
            'user_id' => $userFirst,
            'exact_time' => $currentTime
        ]);

        $secondStatementSendingSchedule = StatementSendingSchedule::factory()->create([
            "guid" => uniqid(),
            'user_id' => $userSecond,
            'exact_time' => $currentTime
        ]);

        $testText = "test text";

        TextForStatementsEloquent::factory()->create(
            [
                "text" => $testText,
                "user_id" => $userFirst->id
            ]
        );

        TextForStatementsEloquent::factory()->create(
            [
                "text" => $testText,
                "user_id" => $userSecond->id
            ]
        );

        Notification::fake();

        $sendNotificationsToUsersAtTimeCommand = new SendNotificationsToUsersAtTimeCommand();
        $sendNotificationsToUsersAtTimeCommand->execute(time: $currentTime);

        Notification::assertSentTo($userFirst,TelegramNotification::class, function ($notification, $channels, $testText){
            $this->assertSame($testText, $notification->getMessage());
            return true;
        });
        Notification::assertSentTo($userSecond,TelegramNotification::class, function ($notification, $channels, $testText){
            $this->assertSame($testText, $notification->getMessage());
            return true;
        });
    }
}
