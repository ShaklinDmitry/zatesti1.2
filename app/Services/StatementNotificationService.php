<?php

namespace App\Services;

use App\Models\Statement;
use Illuminate\Support\Facades\Auth;

class StatementNotificationService
{

    /**
     * Для отправки уведомлений с высказываниями
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotification(){
        $user = \App\Models\User::find(1);
        Auth::login($user);
        $user = auth()->user();

        $statementModel = new Statement();
        $statement = $statementModel->getStatementForSending();

        $user->notify(new \App\Notifications\TelegramNotification($statement->text));

        $statement->markStatementHasBeenSent($statement->id);

        $response = [
            "data" => [
                "message" => "Notification has been sended.",
            ]
        ];

        return response() -> json($response, 200);

    }
}
