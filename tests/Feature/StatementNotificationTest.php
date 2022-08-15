<?php

namespace Tests\Feature;

use App\Models\Statement;
use App\Models\User;
use App\Notifications\TelegramNotification;
use App\Services\StatementNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class StatementNotificationTest extends TestCase
{

    public function test_send_notification(){
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $this->post('/api/statements',
            ['text' => "new statement for testing send statement"]);

        Notification::fake();

        $response = $this->get('/api/notification');

        $response->assertJson(
            [
                "data" => [
                    "message" => "Notification has been sended.",
                ]
            ]
        );
    }


    /**
     * Тестирование отправления уведомлений
     * @return void
     */
//    public function test_send_notifications(){
//        Notification::fake();
//
//        $user = User::factory()->create();
//
//        $user->notify(new TelegramNotification('test notification'));
//
//        Notification::assertSentTo($user, TelegramNotification::class);
//    }


//    /**
//     * тестирование поиска пользователя для отправки высказывания
//     * @return void
//     */
//    public function test_find_user_for_sending_statement(){
//        $this->artisan('migrate:fresh');
//        $user = User::factory()->create();
//        $user = \App\Models\User::find(1);
//        $this->assertNotNull(
//            $user
//        );
//    }


    /**
     * Тестирование функционала на получение сообщений для отправки. Случай когда есть сообщения, которые нужно отправлять
     * @return void
     */
    public function test_get_statement_for_sending_true(){
        $this->artisan('migrate:fresh');

        $response = $this->post('/api/statements',
            ['text' => "new statement for testing send statement"]);

        $statement = new Statement();
        $statementForSending = $statement->getStatementForSending();

        //если не пуст тогда все ОК
        $this->assertNotNull(
            $statementForSending
        );
    }

    /**
     * Тестирование функционала на получение сообщений для отправки. Случай когда нет сообщений, которые нужно отправлять
     * @return void
     */
    public function test_get_statement_for_sending_false(){
        $this->artisan('migrate:fresh');

        $statement = new Statement();
        $statementForSending = $statement->getStatementForSending();

        //если не пуст тогда все ОК
        $this->assertNull(
            $statementForSending
        );
    }

    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
    public function test_mark_sended_statement_true(){
        $this->artisan('migrate:fresh');

        $response = $this->post('/api/statements',
            ['text' => "new statement for testing send statement"]);

        $statementModel = new Statement();
        $statement = $statementModel->getStatementForSending();

        $markedStatement = DB::table('statement')->where('send_date_time','<>', '1970-01-01 00:00:00')->first();

        $this->assertNull(
            $markedStatement
        );
    }

    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
    public function test_mark_sended_statement_false(){
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
