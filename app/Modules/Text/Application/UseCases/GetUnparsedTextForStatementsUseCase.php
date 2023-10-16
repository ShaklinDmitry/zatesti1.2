<?php

namespace App\Modules\Text\Application\UseCases;

use App\Exceptions\TextForStatementsIsNullException;
use App\Modules\Text\Application\DTO\TextForStatementDTO;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class GetUnparsedTextForStatementsUseCase
{

    public function __construct(private TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }


    /**
     * Для получения не распарсенного текста для высказываний
     * @param $userId
     * @return TextForStatementDTO
     * @throws TextForStatementsIsNullException
     */
    public function execute(int $userId): TextForStatementDTO{
        $unParsedText = $this->textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        return $unParsedText;
    }
}
