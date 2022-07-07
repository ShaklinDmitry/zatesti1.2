<?php

namespace App\Services;

use App\Models\Statement;

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
    }
}
