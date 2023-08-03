<?php

namespace App\classes\Statements;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;
use App\Jobs\SendStatements;
use App\Services\StatementScheduleService;
use Illuminate\Support\Facades\Log;

class SendStatementCommand
{

    private StatementNotificationSystem $statementNotification;

    public function __construct(StatementNotificationSystem $statementNotification){
        $this->statementNotification = $statementNotification;
    }

    /**
     * Функция для отправки высказываний(через job)
     * @param string $sendTime
     * @param StatementNotificationSystem $statementNotification
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
