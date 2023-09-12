<?php

namespace App\Classes\Text\Infrastructure\Listeners;

use App\Classes\Text\Application\UseCases\MakeStatementsFromTextUseCase;
use App\Classes\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Classes\Text\MakeStatementsFromTextCommand;
use App\Classes\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Classes\UserResponses\UserResponseType;
use App\Events\UserResponseSended;
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
     * для телеграмма
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserResponseSended $event)
    {
        $user = User::where('telegram_chat_id', $event->chatId)->firstOrFail();

        $textForStatementsRepository = new TextForStatementsRepository();

        $makeStatementsFromTextUseCase = new MakeStatementsFromTextUseCase($user->id, $textForStatementsRepository);
        $makeStatementsFromTextUseCase->execute();

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
