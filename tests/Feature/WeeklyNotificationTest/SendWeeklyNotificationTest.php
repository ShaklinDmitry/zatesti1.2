<?php

namespace Tests\Feature\WeeklyNotificationTest;

use App\classes\Notifications\TelegramNotificationSystem;
use App\classes\WeeklyNotification\SendWeeklyNotificationCommand;
use App\classes\WeeklyNotification\UserWeeklyNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendWeeklyNotificationTest extends TestCase
{
    /**
     * тест отправки недельного уведомления пользователю
     * @return void
     */
    public function test_send_weekly_notification()
    {
        Notification::fake();

        $user = User::factory()->create();

        $notificationText = 'test text';

        $telegramNotificationSystem = new TelegramNotificationSystem();

        $userWeeklyNotification = new UserWeeklyNotification(user: $user, text: $notificationText);

        $sendWeeklyNotification = new SendWeeklyNotificationCommand($telegramNotificationSystem, $userWeeklyNotification);
        $sendWeeklyNotification->execute();

        Notification::assertSentTo($user, TelegramNotificationSystem::class);
    }
}
