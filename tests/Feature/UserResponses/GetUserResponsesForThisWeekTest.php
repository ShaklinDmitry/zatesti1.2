<?php

namespace Tests\Feature\UserResponses;

use App\classes\UserResponses\Exception\NoUserResponsesForThisWeekException;
use App\classes\UserResponses\GetUserResponsesForThisWeekCommand;
use App\Models\UserResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserResponsesForThisWeekTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест на получение ответов пользователей на этой неделе
     * @return void
     * @throws NoUserResponsesForThisWeekException
     */
    public function test_get_user_responses_for_this_week()
    {
        $startOfWeek = now()->startOfWeek()->format('Y-m-d H:i');

        $telegram_chat_id = 1;

        $text1 = 'default text 1';
        $text2 = 'default text 2';

        UserResponse::factory()->create([
            'telegram_chat_id' => $telegram_chat_id,
            'text' => $text1,
            'created_at' => $startOfWeek
        ]);

        UserResponse::factory()->create([
            'telegram_chat_id' => $telegram_chat_id,
            'text' => $text2,
            'created_at' => $startOfWeek
        ]);

        $getUserResponsesForThisWeek = new GetUserResponsesForThisWeekCommand();
        $userResponses = $getUserResponsesForThisWeek->execute($telegram_chat_id);

        $this->assertDatabaseHas('user_response', [
            'text' => $userResponses[0]->text
        ]);

        $this->assertDatabaseHas('user_response', [
            'text' => $userResponses[1]->text
        ]);
    }

    /**
     * тест на получение ответов пользователей на этой неделе если их не было
     * @return void
     * @throws NoUserResponsesForThisWeekException
     */
    public function test_get_user_responses_for_this_week_exception(){
        $this->expectException(NoUserResponsesForThisWeekException::class);

        $getUserResponsesForThisWeek = new GetUserResponsesForThisWeekCommand();
        $userResponses = $getUserResponsesForThisWeek->execute(1);
    }
}
