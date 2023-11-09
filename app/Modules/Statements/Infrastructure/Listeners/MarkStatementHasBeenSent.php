<?php

namespace App\Modules\Statements\Infrastructure\Listeners;

use App\Modules\StatementNotifications\Infrastructure\Notifications\TelegramNotification;
use App\Modules\Statements\Application\UseCases\SetStatementSendDateTimeCommand;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use Illuminate\Support\Facades\Log;

class MarkStatementHasBeenSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private SetStatementSendDateTimeCommand $setStatementSendDateTimeCommand)
    {
    }

    /**
     * Отметить  последне отправленное высказывание
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::debug(serialize($event));

        if($event->notification instanceof TelegramNotification){
            Log::debug('im here');
            $this->setStatementSendDateTimeCommand->execute($event->notification->statementGuid);
        }

    }
}
