<?php

namespace App\Listeners;

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
        $statementService = new StatementService();
        $statementService->markStatementHasBeenSent($event->notifiable['last_statement_id_sent']);
    }
}
