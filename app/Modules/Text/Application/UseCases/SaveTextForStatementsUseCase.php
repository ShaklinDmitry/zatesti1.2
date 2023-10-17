<?php

namespace App\Modules\Text\Application\UseCases;

use App\Modules\Text\Application\DTO\TextForStatementDTO;
use App\Modules\Text\Domain\TextForStatements;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class SaveTextForStatementsUseCase implements SaveTextForStatementsUseCaseInterface
{

    public function __construct(private TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }

    /**
     * Сохранить текст для высказываний
     * @param int $userId
     * @param string $text
     * @return TextForStatementDTO
     */
    public function execute(int $userId, string $text): TextForStatementDTO{
        $textForStatements = new TextForStatements($userId, $text);

        $textForStatementsDTO = $this->textForStatementsRepository->saveTextForStatements($textForStatements->guid, $textForStatements->userId, $textForStatements->text);

        return $textForStatementsDTO;
    }
}
