<?php

namespace App\Domains\Statements;

use App\Domains\Notifications\Interfaces\StatementNotification;
use App\Jobs\SendStatements;
use App\Services\StatementScheduleService;
use Illuminate\Support\Facades\Log;

class SendStatementCommand
{

    private StatementNotification $statementNotification;

    public function __construct(StatementNotification $statementNotification){
        $this->statementNotification = $statementNotification;
    }

    /**
     * Функция для отправки высказываний(через job)
     * @param string $sendTime
     * @param StatementNotification $statementNotification
     * @return void
     */
    public function execute(array $users){
        try{
            SendStatements::dispatch($users, $this->statementNotification);
        }catch (\Exception $exception){
              Log::info($exception->getMessage());
        }
    }
}
