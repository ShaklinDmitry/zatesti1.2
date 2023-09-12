<?php

namespace Tests\Feature\Statements;

use App\Classes\Notifications\TelegramNotificationSystem;
use App\Classes\Statements\Infrastructure\Jobs\SendStatements;
use App\Classes\Statements\SendStatementCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendStatementsTest extends TestCase
{
    use RefreshDatabase;

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
