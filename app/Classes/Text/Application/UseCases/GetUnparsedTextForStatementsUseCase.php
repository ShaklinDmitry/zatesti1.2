<?php

namespace App\Classes\Text\Application\UseCases;

use App\Classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\Classes\Text\Infrastructure\DTO\TextForStatementData;
use App\Exceptions\TextForStatementsIsNullException;

class GetUnparsedTextForStatementsUseCase
{

    public function __construct(private TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }


    /**
     * Для получения не распарсенного текста для высказываний
     * @param $userId
     * @return TextForStatementData
     * @throws TextForStatementsIsNullException
     */
    public function execute(int $userId): TextForStatementData{
        $unParsedText = $this->textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        return $unParsedText;
    }
}
