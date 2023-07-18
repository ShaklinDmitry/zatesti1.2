<?php

namespace Tests\Feature\WeeklyNotificationTest;

use App\Domains\WeeklyNotification\CreateWeeklyNotificationTextCommand;
use App\Models\UserResponse;
use Tests\TestCase;

class CreateWeeklyNotificationTextTest extends TestCase
{
    /**
     * тест для формирование текста за неделю для отправки пользователю
     * @return void
     */
    public function test_create_weekly_notification_text()
    {
        $userResponseText1 = "test text 1";
        $userResponseText2 = "test text 2";
        $telegram_chat_id = 1;

        $userResponse1 = UserResponse::factory()->create(
            ['text' => $userResponseText1,
            'telegram_chat_id' => $telegram_chat_id]
        );
        $userResponse2 = UserResponse::factory()->create(
            ['text' => $userResponseText2,
             'telegram_chat_id' => $telegram_chat_id]
        );

        $userResponses = collect([$userResponse1, $userResponse2]);

        $createWeeklyNotificationText = new CreateWeeklyNotificationTextCommand($userResponses);
        $weeklyNotificationText = $createWeeklyNotificationText->execute();

        $expectedText = '0. '. $userResponseText1 . PHP_EOL .
            '1. '.$userResponseText2.PHP_EOL;

        $this->assertSame($expectedText, $weeklyNotificationText);

    }
}
