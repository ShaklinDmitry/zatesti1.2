<?php

namespace App\Modules\Text\Application\UseCases;

use App\Modules\Statements\Application\UseCases\CreateStatementUseCase;
use App\Modules\Statements\Application\UseCases\CreateStatementUseCaseInterface;
use App\Modules\Statements\Domain\StatementRepositoryInterface;
use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class MakeStatementsFromTextUseCase
{

    /**
     * @param TextForStatementsRepositoryInterface $textForStatementsRepository
     * @param CreateStatementUseCaseInterface $createStatementUseCase
     */
    public function __construct(private TextForStatementsRepositoryInterface $textForStatementsRepository, private CreateStatementUseCaseInterface $createStatementUseCase)
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
            $this->createStatementUseCase->execute($userId, $text);
        }

        $parsedText = $textForStatements->markTextAsParsed();
        $this->textForStatementsRepository->markTextParsed($parsedText->id);
    }
}
