<?php

namespace App\Listeners;

use App\classes\GetTypeOfUserResponseCommand;
use App\classes\Text\MakeStatementsFromTextCommand;
use App\classes\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\classes\UserResponses\UserResponseType;
use App\Events\SendUserResponse;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeStatementsFromText implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendUserResponse $event)
    {
        $user = User::where('telegram_chat_id', $event->chatId)->firstOrFail();

        $makeStatementsFromTextCommand = new MakeStatementsFromTextCommand();
        $makeStatementsFromTextCommand->execute($user->id);
    }

    /**
     * Функция для того чтобы добавлять в очередь только тех слушателей, у которых тип ответа пользователя "Добавить лучшее высказывание"
     * @param $event
     * @return bool|void
     */
    public function shouldQueue($event){
        $userResponseType = new UserResponseType();
        $typeOfUserResponse = $userResponseType->getUserResponseType($event->text);

        if(is_a($typeOfUserResponse, SplitTextOfStatementsUserResponseType::class)){
            return true;
        }
    }
}
