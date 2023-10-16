<?php

namespace App\Modules\Text\Infrastructure\Listeners;

use App\Events\UserResponseSended;
use App\Models\User;
use App\Modules\GetTypeOfUserResponseCommand;
use App\Modules\Text\Application\UseCases\SaveTextForStatementsUseCase;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\UserResponses\Application\GetUserResponseTypeUseCase;
use App\Modules\UserResponses\TypesOfUserResponses\AddTextForStatementsUserResponseType;

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
    public function handle(UserResponseSended $event)
    {
        $user = User::where('telegram_chat_id', $event->chatId)->firstOrFail();

        $saveTextForStatementsUseCase = new SaveTextForStatementsUseCase(userId: $user->id,text: $event->text,textForStatementsRepository: new TextForStatementsRepository());
        $saveTextForStatementsUseCase->execute();
    }


    /**
     * Функция для того чтобы добавлять в очередь только тех слушателей, у которых тип ответа пользователя "Добавить текст для высказываний"
     * @param $event
     * @return bool|void
     */
    public function shouldQueue($event){
        $getUserResponseTypeUseCase = new GetUserResponseTypeUseCase($event->text);
        $typeOfUserResponse = $getUserResponseTypeUseCase->execute();

        if(is_a($typeOfUserResponse, AddTextForStatementsUserResponseType::class)){
            return true;
        }
    }
}
