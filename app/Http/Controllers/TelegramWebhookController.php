<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{

    public function sendAnswer(){
        $user = User::find(3);
        $telegramNotification = new TelegramNotification("this is answer");
        $user->notify($telegramNotification);
    }

}
