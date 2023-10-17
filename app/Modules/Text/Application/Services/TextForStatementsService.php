<?php

namespace App\Modules\Text\Application\Services;

use App\Modules\Statements\Application\UseCases\CreateStatementUseCase;
use App\Modules\Statements\Domain\StatementRepositoryInterface;
use App\Modules\Text\Application\DTO\TextForStatementDTO;
use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class TextForStatementsService implements TextForStatementsServiceInterface
{
    public function __construct(public TextForStatementsRepositoryInterface $textForStatementsRepository, public ?StatementRepositoryInterface $statementRepositoryInterface)
    {
    }

    /**
     * Сохранить текст для высказываний
     * @param int $userId
     * @param string $text
     * @param TextForStatementsRepositoryInterface $textForStatementsRepository
     * @return TextForStatementDTO
     */
    public function saveText(int $userId, string $text): TextForStatementDTO{

        $textForStatements = new TextForStatements($userId, $text);

        $textForStatementsDTO = $this->textForStatementsRepository->saveTextForStatements($textForStatements->guid, $textForStatements->userId, $textForStatements->text);

        return $textForStatementsDTO;
    }

    /**
     * @param int $userId
     * @param TextForStatementsRepositoryInterface $textForStatementsRepository
     * @return void
     */
    public function makeStatementsFromText(int $userId){
        $unParsedText = $this->textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        $textForStatements = new TextForStatements(userId: $unParsedText->userId,text: $unParsedText->text);
        $statements = $textForStatements->parseTextIntoStatements();

        foreach ($statements as $text) {
            $createStatementUseCase = new CreateStatementUseCase($userId, $text, $this->statementRepositoryInterface);
            $createStatementUseCase->execute();
        }

        $parsedText = $textForStatements->markTextAsParsed();
        $textForStatementsRepository->markTextParsed($parsedText->id);
    }
}
