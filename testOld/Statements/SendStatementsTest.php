<?php


use App\Modules\Notifications\Infrastructure\Notifications\TelegramNotification;
use App\Modules\Statements\Infrastructure\Jobs\SendStatements;
use App\Modules\Statements\SendStatementCommand;
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

        $sendStatements = new SendStatementCommand(new TelegramNotification());
        $sendStatements->execute(array());
    }
}
