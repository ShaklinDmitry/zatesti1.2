<?php

namespace App\Jobs;

use App\classes\Text\MakeStatementsFromTextCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeStatementsFromTextForUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $textForStatementsService = new TextForStatementsService();
//        $textForStatementsService->makeStatementsForUser($this->userId);

        $makeStatementsFromTextCommand = new MakeStatementsFromTextCommand();
        $makeStatementsFromTextCommand->execute($this->userId);

    }
}
