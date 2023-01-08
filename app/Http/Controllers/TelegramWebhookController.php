<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{

    public function sendAnswer(Request $request){

      //  Log::debug($request);

        $user = User::find(3);
        $telegramNotification = new TelegramNotification("this is answer");
        $user->notify($telegramNotification);
    }

}
