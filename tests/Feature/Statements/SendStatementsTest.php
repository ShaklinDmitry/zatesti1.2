<?php

namespace Tests\Feature\Statements;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;
use App\classes\Notifications\TelegramNotificationSystem;
use App\classes\Statements\SendStatementCommand;
use App\Jobs\SendStatements;
use Tests\TestCase;

class SendStatementsTest extends TestCase
{
    /**
     * Тестирование того что job запустился
     * @return void
     */
    public function test_send_statements_job_dispatched()
    {
        $this->expectsJobs(SendStatements::class);

        $sendStatements = new SendStatementCommand(new TelegramNotificationSystem());
        $sendStatements->execute(array());
    }
}
