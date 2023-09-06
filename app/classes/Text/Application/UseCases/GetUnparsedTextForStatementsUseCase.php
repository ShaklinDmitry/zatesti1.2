<?php

namespace App\classes\Text\Application\UseCases;

use App\classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\classes\Text\Infrastructure\DTO\TextForStatementData;
use App\Exceptions\TextForStatementsIsNullException;

class GetUnparsedTextForStatementsUseCase
{

    public function __construct(public TextForStatementsRepositoryInterface $textForStatementsRepository)
    {
    }


    /**
     * Для получения не распарсенного текста для высказываний
     * @param $userId
     * @return TextForStatementData
     * @throws TextForStatementsIsNullException
     */
    public function execute($userId): TextForStatementData{
        $unParsedText = $this->textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        if($unParsedText == null){
            throw new TextForStatementsIsNullException();
        }

        return $unParsedText;
    }
}
