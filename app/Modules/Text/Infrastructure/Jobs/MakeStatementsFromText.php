<?php

namespace App\Modules\Text\Infrastructure\Jobs;

use App\Modules\Text\Application\UseCases\GetStatementsFromTextUseCase;
use App\Modules\Text\Application\UseCases\MakeStatementsFromTextCommand;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeStatementsFromText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private int $userId, private TextForStatementsRepository $textForStatementsRepository)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app()

        $makeStatementsFromTextUseCase = new MakeStatementsFromTextCommand($this->textForStatementsRepository, );
        $makeStatementsFromTextUseCase->execute($this->userId);
    }
}
