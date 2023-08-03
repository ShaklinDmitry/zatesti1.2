<?php

namespace App\Listeners;

use App\classes\GetTypeOfUserResponseCommand;
use App\classes\Text\SaveTextForStatementsCommand;
use App\classes\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use App\Events\SendUserResponse;
use App\Models\User;

class SaveTextForStatements
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
        $saveTextForStatements = new SaveTextForStatementsCommand();
        $saveTextForStatements->execute($user->id, $event->text);
    }


    /**
     * Функция для того чтобы добавлять в очередь только тех слушателей, у которых тип ответа пользователя "Добавить текст для высказываний"
     * @param $event
     * @return bool|void
     */
    public function shouldQueue($event){
        $getTypeOfUserResponse = new GetTypeOfUserResponseCommand();
        $typeOfUserResponse = $getTypeOfUserResponse->execute($event->text);

        if(is_a($typeOfUserResponse, AddTextForStatementsUserResponseType::class)){
            return true;
        }
    }
}
