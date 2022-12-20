<?php

namespace App\Services;

use App\Models\Statement;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Support\Facades\Auth;

class StatementNotificationService
{


    /**
     * Для отправки уведомлений с высказываниями
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotification(int $userId){
        $user = User::find($userId);
//        Auth::login($user);
//        $user = auth()->user();

        $statementService = new StatementService();
        $statement = $statementService->getStatementForSending($userId);

        $telegramNotification = new TelegramNotification($statement->text);
        $user->notify($telegramNotification);

        $statement->markStatementHasBeenSent($statement->id);

        $response = [
            "data" => [
                "message" => "Notification has been sended.",
            ]
        ];

        return response() -> json($response, 200);
    }
}
