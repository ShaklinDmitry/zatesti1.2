<?php

namespace App\Modules\Text\Application\UseCases;

use App\Modules\Statements\Application\UseCases\CreateStatementCommand;
use App\Modules\Statements\Application\UseCases\CreateStatementCommandInterface;
use App\Modules\Statements\Domain\StatementRepositoryInterface;
use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class MakeStatementsFromTextCommand implements MakeStatementsFromTextCommandInterface
{

    /**
     * @param TextForStatementsRepositoryInterface $textForStatementsRepository
     * @param CreateStatementCommandInterface $createStatementCommand
     */
    public function __construct(private TextForStatementsRepositoryInterface $textForStatementsRepository, private CreateStatementCommandInterface $createStatementCommand)
    {
    }

    /**
     * @param int $userId
     * @return void
     */
    public function execute(int $userId): void {
        $unParsedText = $this->textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        $textForStatements = new TextForStatements(userId: $unParsedText->userId,text: $unParsedText->text);
        $statements = $textForStatements->parseTextIntoStatements();

        foreach ($statements as $text) {
            $this->createStatementCommand->execute($userId, $text);
        }

        $parsedText = $textForStatements->markTextAsParsed();
        $this->textForStatementsRepository->markTextParsed($parsedText->guid);
    }
}
