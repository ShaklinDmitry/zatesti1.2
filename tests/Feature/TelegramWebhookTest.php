<?php

namespace Tests\Feature;

use App\Events\SendUserResponse;
use App\Listeners\SaveUserResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TelegramWebhookTest extends TestCase
{

    /**
     * Тест для запуска события при получение ответа от пользователя
     * @return void
     */
    public function test_send_user_response_event(){
        Event::fake();
        $this->post('/api/telegram-webhook',
            [
                'message' =>
                    [
                        'chat' => ['id' => 1],
                        'text' => 'test text'
                    ],
            ]
        );
        Event::assertDispatched(SendUserResponse::class);

    }


}
