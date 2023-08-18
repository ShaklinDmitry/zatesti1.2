<?php

namespace App\classes\Text\Infrastructure;


use App\classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\Models\TextForStatementsModel;

class TextForStatementsRepository implements TextForStatementsRepositoryInterface
{
    /**
     * Функция для возврата нераспарсенного текста
     * @param int $userId
     * @return mixed
     */
    public function getUnparsedTextForStatementsByUserId(int $userId)
    {
        return TextForStatementsModel::where(['is_parsed' => 0], ['user_id' => $userId])->first();
    }
}
