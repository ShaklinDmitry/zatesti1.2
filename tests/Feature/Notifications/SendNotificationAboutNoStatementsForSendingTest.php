<?php

namespace Tests\Feature\Notifications;

use App\classes\Notifications\TelegramNotificationSystem;
use App\Jobs\SendStatements;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNotificationAboutNoStatementsForSendingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_notification_about_no_statements_for_sending()
    {
        Notification::fake();
        $user = User::factory()->create();

        $telegramNotification = new TelegramNotificationSystem();
        $sendStatements = new SendStatements(array($user), $telegramNotification);
        $sendStatements->handle();

        Notification::assertSentTo($user,TelegramNotificationSystem::class, function ($notification, $channels){
            $this->assertSame('There is no statements for sending', $notification->getMessage());
            return true;
        });
    }
}
