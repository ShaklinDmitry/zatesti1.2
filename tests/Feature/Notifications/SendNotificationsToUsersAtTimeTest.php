<?php

namespace Tests\Feature\Notifications;

use App\Models\StatementEloquent;
use App\Models\StatementSendingSchedule;
use App\Models\TextForStatementsEloquent;
use App\Models\User;
use App\Modules\StatementNotifications\Application\UseCases\SendNotificationsToUsersAtTimeCommandInterface;
use App\Modules\StatementNotifications\Infrastructure\Notifications\TelegramNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNotificationsToUsersAtTimeTest extends TestCase
{

    use RefreshDatabase;

    public function test_send_notifications_to_users_at_time()
    {
        $currentTime = date("H:i");

        $user = User::factory()->create();

        StatementSendingSchedule::factory()->create([
            "guid" => uniqid(),
            'user_id' => $user,
            'exact_time' => $currentTime
        ]);

        $testText = "test text";

        StatementEloquent::factory()->create(
          [
              'guid' => uniqid(),
              'text' => $testText,
              'user_id' => $user->id
          ]
        );

        Notification::fake();

        $sendNotificationsToUsersAtTimeCommand = app(SendNotificationsToUsersAtTimeCommandInterface::class);
        $sendNotificationsToUsersAtTimeCommand->execute(time: $currentTime);

        Notification::assertSentTo($user,TelegramNotification::class, function ($notification, $channels){
            $this->assertSame("test text", $notification->getMessage());
            return true;
        });
    }
}
