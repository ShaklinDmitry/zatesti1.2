<?php

namespace Tests\Feature\WeeklyNotificationTest;

use App\classes\WeeklyNotification\GetUserWeeklyNotifications;
use App\Models\StatementSendingSchedule;
use App\Models\User;
use App\Models\UserResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserWeeklyNotificationsTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_user_weekly_notifications()
    {
        $telegramChatId = 1;

        $user = User::factory()->create([
            'telegram_chat_id' => $telegramChatId
        ]);

        StatementSendingSchedule::factory()->create([
            'user_id' => $user->id
        ]);

        $startOfWeek = now()->startOfWeek()->format('Y-m-d H:i');

        $userResponseText1 = 'test text 1';
        $userResponse1 = UserResponse::factory()->create([
            'telegram_chat_id' => $telegramChatId,
            'text' => $userResponseText1,
            'created_at' => $startOfWeek
        ]);

        $userResponseText2 = 'test text 2';
        $userResponse2 = UserResponse::factory()->create([
            'telegram_chat_id' => $telegramChatId,
            'text' => $userResponseText2,
            'created_at' => $startOfWeek
        ]);

        $getUserWeeklyNotifications = new GetUserWeeklyNotifications();
        $userWeeklyNotifications = $getUserWeeklyNotifications->execute();

    //    dd($userWeeklyNotifications);

        $summaryText = '0. test text 1'. PHP_EOL. '1. test text 2'.PHP_EOL;

        $this->assertSame($summaryText, $userWeeklyNotifications[0]->text);
        $this->assertSame($user->id, $userWeeklyNotifications[0]->user->id);

    }
}
