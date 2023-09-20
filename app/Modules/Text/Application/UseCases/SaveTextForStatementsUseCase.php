<?php

namespace App\Modules\Text\Application\UseCases;

use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class SaveTextForStatementsUseCase
{


    public function __construct(private int $userId, private string $text, private TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }

    /**
     * Сохранить текст для высказываний
     * @return TextForStatements
     */
    public function execute(): TextForStatements{
        $textForStatementsData = $this->textForStatementsRepository->saveTextForStatements($this->userId, $this->text);

        $textForStatements = new TextForStatements($textForStatementsData->id, $textForStatementsData->userId, $textForStatementsData->text);
        return $textForStatements;
    }
}
