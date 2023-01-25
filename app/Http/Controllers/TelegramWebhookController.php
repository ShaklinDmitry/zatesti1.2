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

    /**
     * Здесь происходит обработка ответа который пришел через телеграмм
     * @param Request $request
     * @param UserResponseService $userResponseService
     * @return void
     */
    public function sendAnswer(Request $request, UserResponseService $userResponseService){
        $userResponseService->saveUserResponse($request['message']['chat']['id'], $request['message']['text']);

    }


}
