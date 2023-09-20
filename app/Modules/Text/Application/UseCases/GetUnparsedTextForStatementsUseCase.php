<?php

namespace App\Modules\Text\Application\UseCases;

use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;
use App\Modules\Text\Infrastructure\DTO\TextForStatementData;
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
