<?php

namespace App\Modules\Text\Application;

use App\Modules\Statements\Application\UseCases\CreateStatementUseCase;
use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class TextForStatementsService implements TextForStatementsServiceInterface
{

    public function saveText(int $userId, string $text, TextForStatementsRepositoryInterface $textForStatementsRepository){

        $textForStatements = new TextForStatements($userId, $text);

        $textForStatementsData = $textForStatementsRepository->saveTextForStatements($userId, $text);


        return $textForStatements;
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
