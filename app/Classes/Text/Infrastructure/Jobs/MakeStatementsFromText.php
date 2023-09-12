<?php

namespace App\Classes\Text\Infrastructure\Jobs;

use App\Classes\Text\Application\UseCases\GetStatementsFromTextUseCase;
use App\Classes\Text\Application\UseCases\MakeStatementsFromTextUseCase;
use App\Classes\Text\Infrastructure\Repositories\TextForStatementsRepository;
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
        $makeStatementsFromTextUseCase = new MakeStatementsFromTextUseCase($this->textForStatementsRepository, $this->userId);
        $makeStatementsFromTextUseCase->execute();
    }
}
