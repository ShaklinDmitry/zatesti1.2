<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Modules\Notifications\Infrastructure\Notifications\TelegramNotificationSystem;
use App\Modules\Statements\Infrastructure\Jobs\SendStatements;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNotificationAboutNoStatementsForSendingTest extends TestCase
{
    use RefreshDatabase;

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
