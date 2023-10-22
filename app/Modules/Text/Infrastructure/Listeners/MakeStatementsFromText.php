<?php

namespace App\Modules\Text\Infrastructure\Listeners;

use App\Events\UserResponseSended;
use App\Models\User;
use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommand;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommandInterface;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\UserResponses\Domain\UserResponseType;
use App\Modules\UserResponses\TypesOfUserResponses\SplitTextOfStatementsUserResponseType;
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
    public function handle(UserResponseSended $event, MakeStatementsFromTextCommandInterface $makeStatementsFromTextCommand)
    {
        $user = User::where('telegram_chat_id', $event->chatId)->firstOrFail();

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
