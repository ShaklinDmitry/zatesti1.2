<?php

namespace App\Classes\Text\Application\UseCases;

use App\Classes\Statements\Application\UseCases\CreateStatementUseCase;
use App\Classes\Text\Domain\TextForStatements;
use App\Classes\Text\Domain\TextForStatementsRepositoryInterface;

class MakeStatementsFromTextUseCase
{

    public function __construct(private int $userId, private TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }

    public function execute(): void {
        $getUnparsedTextForStatementsUseCase = new GetUnparsedTextForStatementsUseCase($this->textForStatementsRepository);
        $unparsedText = $getUnparsedTextForStatementsUseCase->execute($this->userId);

        $textForStatements = new TextForStatements($unparsedText->id ,$unparsedText->userId, $unparsedText->text);
        $statements = $textForStatements->parseTextIntoStatements();

        foreach ($statements as $text) {
            $createStatementUseCase = new CreateStatementUseCase($this->userId, $text, $this->textForStatementsRepository);
            $createStatementUseCase->execute();
        }

        $markTextAsParsedUseCase = new MarkTextAsParsedUseCase($this->textForStatementsRepository);
        $markTextAsParsedUseCase->execute($textForStatements);
    }
}
