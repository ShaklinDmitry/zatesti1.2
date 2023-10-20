<?php

namespace App\Modules\Text\Infrastructure\Jobs;

use App\Modules\Statements\Application\UseCases\CreateStatementCommandInterface;
use App\Modules\Text\Application\UseCases\GetStatementsFromTextUseCase;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommand;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommandInterface;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeStatementsFromText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param int $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @param MakeStatementsFromTextCommandInterface $makeStatementsFromTextCommand
     * @return void
     */
    public function handle(MakeStatementsFromTextCommandInterface $makeStatementsFromTextCommand)
    {
        $makeStatementsFromTextCommand->execute($this->userId);
    }
}
