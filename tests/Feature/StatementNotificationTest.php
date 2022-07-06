<?php

namespace Tests\Feature;

use App\Models\Statement;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

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


    /**
     * тестирование поиска пользователя для отправки высказывания
     * @return void
     */
    public function test_find_user_for_sending_statement(){
        $this->artisan('migrate:fresh');
        $user = User::factory()->create();
        $user = \App\Models\User::find(1);
        $this->assertNotNull(
            $user
        );
    }


    /**
     * Тестирование получения неотправленных сообщений
     * @return void
     */
    public function test_getting_not_sended_statement(){
        $this->artisan('migrate:fresh');

        $response = $this->post('/api/statements',
            ['text' => "new statement for testing send statement"]);

        $statement = new Statement();
        $notSendedStatement = $statement->getStatementForSending();

        $this->assertNotNull(
            $notSendedStatement
        );
    }

    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
    public function test_marking_sended_statement(){
        $this->artisan('migrate:fresh');

        $response = $this->post('/api/statements',
            ['text' => "new statement for testing send statement"]);

        $statementModel = new Statement();
        $statement = $statementModel->getStatementForSending();

        $statement->markStatementHasBeenSent($statement->id);

        $markedStatement = DB::table('statement')->where('send_date_time','<>', '1970-01-01 00:00:00')->first();

        $this->assertNotNull(
            $markedStatement
        );
    }


}
