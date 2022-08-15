<?php

namespace App\Services;

use App\Models\Statement;
use Illuminate\Support\Facades\Auth;

class StatementNotificationService
{

    /*
     * Отправить высказывание
     * @return void
     */
    public function sendStatementNotification(){
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
