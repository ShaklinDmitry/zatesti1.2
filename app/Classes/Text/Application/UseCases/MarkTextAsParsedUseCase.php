<?php

namespace App\Classes\Text\Application\UseCases;

use App\Classes\Text\Domain\TextForStatements;
use App\Classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\Models\TextForStatementsEloquent;

class MarkTextAsParsedUseCase
{

    public function __construct(private TextForStatementsRepositoryInterface $textForStatementsRepository)
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

        return $parsedText;
    }
}
