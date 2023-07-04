<?php

namespace Tests\Feature\Statements;

use App\Domains\Notifications\Interfaces\StatementNotification;
use App\Domains\Notifications\TelegramNotification;
use App\Domains\Statements\SendStatementCommand;
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

        $sendStatements = new SendStatementCommand(new TelegramNotification());
        $sendStatements->execute(array());
    }
}
