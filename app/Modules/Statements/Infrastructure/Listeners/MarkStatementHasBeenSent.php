<?php

namespace App\Modules\Statements\Infrastructure\Listeners;

use App\Modules\Statements\Application\UseCases\SetStatementSendDateTimeUseCase;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use App\Modules\Statements\StatementSentStatusUpdater;

class MarkStatementHasBeenSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
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
        $statementRepository = new StatementRepository();

        $setStatementSendDateTimeUseCase = new SetStatementSendDateTimeUseCase($event->notifiable['last_statement_id_sent'], $statementRepository);
        $setStatementSendDateTimeUseCase->execute();
    }
}
