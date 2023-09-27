<?php

namespace App\Modules\Text\Infrastructure\Listeners;

use App\Modules\Text\Application\UseCases\MakeStatementsFromTextUseCase;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\Text\MakeStatementsFromTextCommand;
use App\Modules\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
use App\Modules\UserResponses\UserResponseType;
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