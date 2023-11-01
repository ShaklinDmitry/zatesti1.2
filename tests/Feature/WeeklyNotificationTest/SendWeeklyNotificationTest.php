<?php

namespace Tests\Feature\WeeklyNotificationTest;

use App\Models\User;
use App\Modules\StatementNotifications\Infrastructure\Notifications\TelegramNotification;
use App\Modules\WeeklyNotification\UserWeeklyNotification;
use App\Modules\WeeklyNotification\UserWeeklyNotificationDTO;
use App\Modules\WeeklyNotification\WeeklyNotificationSender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendWeeklyNotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * тест отправки недельного уведомления пользователю
     * @return void
     */
    public function test_send_weekly_notification()
    {
        Notification::fake();

        $user = User::factory()->create();

        $notificationText = 'test text';

        $telegramNotificationSystem = new TelegramNotification();

        $userWeeklyNotification = new UserWeeklyNotificationDTO(user: $user, text: $notificationText);

        $weeklyNotificationSender = new WeeklyNotificationSender($telegramNotificationSystem, $userWeeklyNotification);
        $weeklyNotificationSender->sendWeeklyNotification();

        Notification::assertSentTo($user, TelegramNotification::class);
    }
}
