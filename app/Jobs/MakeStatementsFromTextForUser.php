<?php

namespace App\Jobs;

use App\classes\Statements\Application\UseCases\CreateStatementUseCase;
use App\classes\Statements\Domain\Statement;
use App\classes\Text\Application\UseCases\GetStatementsFromTextUseCase;
use App\classes\Text\Application\UseCases\GetUnparsedTextForStatementsUseCase;
use App\classes\Text\Application\UseCases\MarkTextAsParsedUseCase;
use App\classes\Text\Domain\TextForStatements;
use App\classes\Text\Infrastructure\TextForStatementsRepository;
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
        $textForStatementsRepository = new TextForStatementsRepository();

        $getUnparsedTextForStatementsUseCase = new GetUnparsedTextForStatementsUseCase($textForStatementsRepository);
        $unparsedText = $getUnparsedTextForStatementsUseCase->execute($this->userId);

        $textForStatements = new TextForStatements($unparsedText->id ,$unparsedText->userId, $unparsedText->text);
        $statements = $textForStatements->parseTextIntoStatements();

        foreach ($statements as $text) {
            $createStatementUseCase = new CreateStatementUseCase($textForStatementsRepository);
            $createStatementUseCase->execute($this->userId, $text);
        }

        $markTextAsParsedUseCase = new MarkTextAsParsedUseCase($textForStatementsRepository);
        $markTextAsParsedUseCase->execute($textForStatements);
    }
}
