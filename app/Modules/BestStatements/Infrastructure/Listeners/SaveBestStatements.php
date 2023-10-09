<?php

namespace App\Modules\BestStatements\Infrastructure\Listeners;

use App\Events\UserResponseSended;
use App\Modules\BestStatements\Application\AddBestStatementUseCase;
use App\Modules\BestStatements\Infrastructure\Repositories\BestStatementRepository;
use App\Modules\BestStatements\SaveBestStatementCommand;
use App\Modules\GetTypeOfUserResponseCommand;
use App\Modules\UserResponses\Application\GetUserResponseTypeUseCase;
use App\Modules\UserResponses\TypesOfUserResponses\AddBestStatementUserResponseType;
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
     * @param  \App\Events\UserResponseSended  $event
     * @return void
     */
    public function handle(UserResponseSended $event)
    {
        $bestStatementRepository = new BestStatementRepository();
        $addBestStatementUseCase = new AddBestStatementUseCase(chatId: $event->chatId, text: $event->text,bestStatementRepository: $bestStatementRepository);
        $addBestStatementUseCase->execute();
    }

    /**
     * Функция для того чтобы добавлять в очередь только тех слушателей, у которых тип ответа пользователя "Добавить лучшее высказывание"
     * @param $event
     * @return bool|void
     */
    public function shouldQueue($event){
        $getUserResponseTypeUseCase = new GetUserResponseTypeUseCase($event->text);
        $typeOfUserResponse = $getUserResponseTypeUseCase->execute();

        if(is_a($typeOfUserResponse, AddBestStatementUserResponseType::class)){
            return true;
        }
    }
}
