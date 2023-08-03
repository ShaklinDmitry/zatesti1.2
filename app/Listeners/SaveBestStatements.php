<?php

namespace App\Listeners;

use App\classes\BestStatements\SaveBestStatementCommand;
use App\classes\GetTypeOfUserResponseCommand;
use App\classes\TypesOfUserResponses\AddBestStatementUserResponseType;
use App\Events\SendUserResponse;
use App\Services\BestStatementService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveBestStatements implements ShouldQueue
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
     * @param  \App\Events\SendUserResponse  $event
     * @return void
     */
    public function handle(SendUserResponse $event)
    {
        $saveBestStatementCommand = new SaveBestStatementCommand();
        $saveBestStatementCommand->execute($event->chatId, $event->text);

    }

    /**
     * Функция для того чтобы добавлять в очередь только тех слушателей, у которых тип ответа пользователя "Добавить лучшее высказывание"
     * @param $event
     * @return bool|void
     */
    public function shouldQueue($event){
        $getTypeOfUserResponse = new GetTypeOfUserResponseCommand();
        $typeOfUserResponse = $getTypeOfUserResponse->execute($event->text);

        if(is_a($typeOfUserResponse, AddBestStatementUserResponseType::class)){
            return true;
        }
    }
}
