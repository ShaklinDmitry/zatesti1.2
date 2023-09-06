<?php

namespace App\classes\Text\Application\UseCases;

use App\classes\Text\Domain\TextForStatements;
use App\classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\Models\TextForStatementsEloquent;

class MarkTextAsParsedUseCase
{

    public function __construct(public TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }

    /**
     * Отметить что текст был распарсен
     * @param int $textId
     * @return mixed
     */
    public function execute(TextForStatements $textForStatements){

        $parsedText = $textForStatements->markTextAsParsed();

        $markTextResult = $this->textForStatementsRepository->markTextParsed($parsedText->id);

        return $markTextResult;
    }
}
