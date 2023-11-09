<?php

namespace App\Modules\Text\Infrastructure\Listeners;

use App\Events\UserResponseSended;
use App\Models\User;
use App\Modules\GetTypeOfUserResponseCommand;
use App\Modules\Text\Application\Services\TextForStatementsService;
use App\Modules\Text\Application\Services\TextForStatementsServiceInterface;
use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommand;
use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommandInterface;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\UserResponses\Application\GetUserResponseTypeUseCase;
use App\Modules\UserResponses\TypesOfUserResponses\AddTextForStatementsUserResponseType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SaveTextForStatements
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private SaveTextForStatementsCommandInterface $saveTextForStatementsCommand)
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

        Log::debug('save text line 40');

        $this->saveTextForStatementsCommand->execute(userId: $user->id, text: $event->text);

    }


    /**
     * @param $event
     * @return bool|void
     */
    public function shouldQueue($event){
        $getUserResponseTypeUseCase = new GetUserResponseTypeUseCase($event->text);
        $typeOfUserResponse = $getUserResponseTypeUseCase->execute();

        Log::debug("shouldQueue for save text");

        if(is_a($typeOfUserResponse, AddTextForStatementsUserResponseType::class)){
            Log::debug("shouldQueue for save text is true!!!!");

            return true;
        }
    }
}
