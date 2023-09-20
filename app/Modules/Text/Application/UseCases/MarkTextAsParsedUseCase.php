<?php

namespace App\Modules\Text\Application\UseCases;

use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;
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
