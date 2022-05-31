<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Отослать высказывание клиенту
     *
     * @return void
     */
    public function sendNotification(){
        $user = \App\Models\User::find(1);
        Auth::login($user);
        $user = auth()->user();

        $statementModel = new Statement();
        $statement = $statementModel->getNotSendedStatement();

        $user->notify(new \App\Notifications\TelegramNotification($statement->text));

        $statement->markSendedStatement($statement->id);
    }
}
