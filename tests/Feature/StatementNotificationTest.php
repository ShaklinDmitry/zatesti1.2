<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class StatementNotificationTest extends TestCase
{

    /**
     * Тестирование отправления уведомлений
     * @return void
     */
    public function test_send_notifications(){
        Notification::fake();

        $user = User::factory()->create();

        $user->notify(new TelegramNotification('test notification'));

        Notification::assertSentTo($user, TelegramNotification::class);
    }

}
