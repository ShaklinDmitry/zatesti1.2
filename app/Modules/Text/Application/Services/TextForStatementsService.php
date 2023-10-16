<?php

namespace App\Modules\Text\Application\Services;

use App\Modules\Statements\Application\UseCases\CreateStatementUseCase;
use App\Modules\Text\Application\DTO\TextForStatementDTO;
use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class TextForStatementsService implements TextForStatementsServiceInterface
{

    /**
     * Сохранить текст для высказываний
     * @param int $userId
     * @param string $text
     * @param TextForStatementsRepositoryInterface $textForStatementsRepository
     * @return TextForStatementDTO
     */
    public function saveText(int $userId, string $text, TextForStatementsRepositoryInterface $textForStatementsRepository): TextForStatementDTO{

        $textForStatements = new TextForStatements($userId, $text);

        $textForStatementsDTO = $textForStatementsRepository->saveTextForStatements($textForStatements->guid, $textForStatements->userId, $textForStatements->text);

        return $textForStatementsDTO;
    }

    public function makeStatementsFromText(int $userId, TextForStatementsRepositoryInterface $textForStatementsRepository){
        $unParsedText = $textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        $textForStatements = new TextForStatements($unParsedText->id ,$unParsedText->userId, $unParsedText->text);
        $statements = $textForStatements->parseTextIntoStatements();

        foreach ($statements as $text) {
            $createStatementUseCase = new CreateStatementUseCase($userId, $text, $textForStatementsRepository);
            $createStatementUseCase->execute();
        }

        $parsedText = $textForStatements->markTextAsParsed();
        $textForStatementsRepository->markTextParsed($parsedText->id);
    }
}
