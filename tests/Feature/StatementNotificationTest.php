<?php

namespace Tests\Feature;

use App\Models\Statement;
use App\Models\User;
use App\Notifications\TelegramNotification;
use App\Services\NotificationService;
use App\Services\StatementService;
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

        $response = $this->actingAs($user)->post('/api/statements',
            ['text' => "new statement for testing send statement"],
            ["Accept"=>"application/json"]);

        $notificationService = new NotificationService();
        $notificationService->sendNotification($user->id);

        Notification::assertSentTo($user, TelegramNotification::class);
    }


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

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements',
            ['text' => "new statement for testing send statement"],
            ["Accept"=>"application/json"]);

        $statementService = new StatementService();
        $statement = $statementService->getStatementForSending($user->id);


        $this->assertSame(
            $statement->text, "new statement for testing send statement"
        );
    }

    /**
     * Тестирование функционала на получение сообщений для отправки. Случай когда нет сообщений, которые нужно отправлять
     * @return void
     */
    public function test_get_statement_for_sending_false(){
        $this->expectExceptionMessage('There are no statements to send to the user');

        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $statementService = new StatementService();
        $statement = $statementService->getStatementForSending($user->id);
    }



    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
    public function test_mark_sended_statement_false(){
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements',
            ['text' => "new statement for testing send statement"],
            ["Accept"=>"application/json"]);

        $statementService = new StatementService();
        $statement = $statementService->getStatementForSending($user->id);

        $markedStatement = DB::table('statement')->where('send_date_time','<>', '1970-01-01 00:00:00')
                                                        ->where('user_id', $user->id)->first();

        $this->assertNull(
            $markedStatement
        );
    }

    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
    public function test_mark_sended_statement_true(){
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/statements',
            ['text' => "new statement for testing send statement"],
            ["Accept"=>"application/json"]);

        $statementService = new StatementService();
        $statement = $statementService->getStatementForSending($user->id);

        $statement->markStatementHasBeenSent($statement->id);

        $markedStatement = DB::table('statement')->where('send_date_time','<>', '1970-01-01 00:00:00')
                                                        ->where('user_id', $user->id)->first();

        $this->assertNotNull(
            $markedStatement
        );
    }


}
