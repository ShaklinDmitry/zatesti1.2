<?php

namespace App\Http\Controllers;

use App\Events\SendUserResponse;
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
    public function sendUserAnswer(Request $request){
        try{
            $chatId = $request['message']['chat']['id'];
            $text = $request['message']['text'];

            SendUserResponse::dispatch($chatId, $text);

        }catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }


}
