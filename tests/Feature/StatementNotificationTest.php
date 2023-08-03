<?php

namespace Tests\Feature;

use App\classes\Notifications\SaveIdOfLastSentStatementCommand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatementNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование отправления уведомлений
     * @return void
     */
//    public function test_send_notifications(){
//        Notification::fake();
//
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)->post('/api/statements',
//            ['text' => "new statement for testing send statement"],
//            ["Accept"=>"application/json"]);
//
//        $statement = Statement::where('user_id', $user->id)
//            ->where('send_date_time', '1970-01-01 00:00:00')
//            ->where('text','<>','')
//            ->first();
//
//        $sendNotificationCommand = new SendNotificationCommand(new TelegramNotificationSystem());
//        $sendNotificationCommand->execute($user->id, $statement);
//
//        Notification::assertSentTo($user, TelegramNotificationSystem::class);
//    }


    /**
     * Тестиорование на то какое сообщение будет отправляться при отсутсвии высказываний у пользователя
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     * @throws \WendellAdriel\ValidatedDTO\Exceptions\CastTargetException
     * @throws \WendellAdriel\ValidatedDTO\Exceptions\MissingCastTypeException
     */
//    public function test_send_notification_with_message_that_user_has_no_statements_for_sending(){
//
//       Notification::fake();
//
//        $user = User::factory()->create(['id' => 1]);
//
//        $telegramNotification = new TelegramNotificationSystem();
//
//        $sendStatements = new SendStatements(array($user), $telegramNotification);
//
//        $sendStatements->handle();
//
//        Notification::assertSentTo($user,TelegramNotificationSystem::class, function ($notification, $channels){
//            $this->assertSame('There is no statements for sending', $notification->getMessage());
//            return true;
//        });
//    }


    /**
     * Тестирование функционала на получение сообщений для отправки. Случай когда есть сообщения, которые нужно отправлять
     * @return void
     */
//    public function test_get_statement_for_sending_true(){
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)->post('/api/statements',
//            ['text' => "new statement for testing send statement"],
//            ["Accept"=>"application/json"]);
//
//        $statementService = new StatementService();
//        $statement = $statementService->getStatementForSending($user->id);
//
//
//        $this->assertSame(
//            $statement->text, "new statement for testing send statement"
//        );
//    }

    /**
     * Тестирование функционала на получение сообщений для отправки. Случай когда нет сообщений, которые нужно отправлять
     * @return void
     */
//    public function test_get_statement_for_sending_false(){
//        $this->expectExceptionMessage('There are no statements to send to the user');
//
//        $user = User::factory()->create();
//
//        $statementService = new StatementService();
//        $statement = $statementService->getStatementForSending($user->id);
//    }


    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
//    public function test_mark_sended_statement_false(){
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)->post('/api/statements',
//            ['text' => "new statement for testing send statement"],
//            ["Accept"=>"application/json"]);
//
//        $statementService = new StatementService();
//        $statement = $statementService->getStatementForSending($user->id);
//
//        $markedStatement = DB::table('statement')->where('send_date_time','<>', '1970-01-01 00:00:00')
//                                                        ->where('user_id', $user->id)->first();
//
//        $this->assertNull(
//            $markedStatement
//        );
//    }

    /**
     * Тестирование пометки отправленного высказывания(чтобы далее оно больше не отправлялось повторно)
     * @return void
     */
//    public function test_mark_sended_statement_true(){
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)->post('/api/statements',
//            ['text' => "new statement for testing send statement"],
//            ["Accept"=>"application/json"]);
//
//        $statementService = new StatementService();
//        $statement = $statementService->getStatementForSending($user->id);
//
//        $statementService->markStatementHasBeenSent($statement->id);
//
//        $markedStatement = DB::table('statement')->where('send_date_time','<>', '1970-01-01 00:00:00')
//                                                        ->where('user_id', $user->id)->first();
//
//        $this->assertNotNull(
//            $markedStatement
//        );
//    }

    /**
     * тест на факт отправки еженедельного сообщения пользователю
     * @return void
     */
//    public function test_send_weekly_report(){
//        Notification::fake();
//
//        $currentTime = date("H:i");
//
//        StatementSendingSchedule::factory()->create([
//            'user_id' => 1,
//            'exact_time' => $currentTime
//        ]);
//
//        $telegram_chat_id = 1;
//
//        $user = User::factory()->create([
//            'id' => 1,
//            'telegram_chat_id' => $telegram_chat_id
//        ]);
//
//        $startOfWeek = now()->startOfWeek()->format('Y-m-d H:i');
//
//        UserResponse::factory()->create([
//            'telegram_chat_id' => $telegram_chat_id,
//            'text' => 'default text',
//            'created_at' => $startOfWeek
//        ]);
//
//        $notificationService = new NotificationService();
//        $notificationService->sendWeeklyReport();
//
//        Notification::assertSentTo($user, TelegramNotificationSystem::class);
//    }

    /**
     * тест для сохранения id последнего отправленного уведомления
     * @return void
     */
    public function test_save_id_of_last_sent_statement(){
        $user = User::factory()->create();
        $statementId = 1;

        $saveIdOfLastSentStatement = new SaveIdOfLastSentStatementCommand();
        $saveIdOfLastSentStatement->execute($user->id, $statementId);

        $this->assertDatabaseHas('users',[
            'last_statement_id_sent' => $statementId
        ]);
    }

}
