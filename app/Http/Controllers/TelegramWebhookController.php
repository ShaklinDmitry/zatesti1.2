<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserResponseRequest;
use App\Models\User;
use App\Notifications\TelegramNotification;
use App\Services\UserResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{

    public function sendAnswer(UserResponseRequest $request, UserResponseService $userResponseService){

        $user = User::find(3);
        $telegramNotification = new TelegramNotification("this is answer");
        $user->notify($telegramNotification);

        Log::debug('jjjbbb');
        $userResponseService->saveUserResponse();

        $responseData = [
            "data" => [
                "message" => "Statement was create successfull.",
            ]
        ];

        return response() -> json($responseData,200);
    }

}
