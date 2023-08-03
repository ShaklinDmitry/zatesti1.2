<?php

namespace App\Listeners;

use App\classes\Statements\StatementSentStatusUpdater;
use App\Services\StatementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        $statementSentStatusUpdater = new StatementSentStatusUpdater();
        $statementSentStatusUpdater->setSentStatus($event->notifiable['last_statement_id_sent']);

    }
}
