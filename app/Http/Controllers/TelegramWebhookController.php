<?php

namespace App\Http\Controllers;

use App\Events\UserResponseSended;
use App\Models\User;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommandInterface;
use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommandInterface;
use App\Modules\UserResponses\Application\GetUserResponseTypeUseCase;
use App\Modules\UserResponses\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Services\UserResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    /**
     * @param SaveTextForStatementsCommandInterface $saveTextForStatementsCommand
     * @param MakeStatementsFromTextCommandInterface $makeStatementsFromTextCommand
     */
    public function __construct(private SaveTextForStatementsCommandInterface $saveTextForStatementsCommand, private MakeStatementsFromTextCommandInterface $makeStatementsFromTextCommand)
    {
    }


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

            Log::debug('TelegramWebhookController', ['request' => $request]);

            $getUserResponseTypeUseCase = new GetUserResponseTypeUseCase($text);
            $typeOfUserResponse = $getUserResponseTypeUseCase->execute();
            $user = User::where('telegram_chat_id', $chatId)->firstOrFail();

            if(is_a($typeOfUserResponse, AddTextForStatementsUserResponseType::class)){
                $this->saveTextForStatementsCommand->execute(userId: $user->id, text: $text);
            }

            if(is_a($typeOfUserResponse, SplitTextOfStatementsUserResponseType::class)){
                $this->makeStatementsFromTextCommand->execute($user->id);
            }

        }catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }


}
