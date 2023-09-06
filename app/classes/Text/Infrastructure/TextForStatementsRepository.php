<?php

namespace App\classes\Text\Infrastructure;


use App\classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\classes\Text\Infrastructure\DTO\TextForStatementData;
use App\Models\TextForStatementsEloquent;

class TextForStatementsRepository implements TextForStatementsRepositoryInterface
{
    /**
     * Функция для возврата нераспарсенного текста
     * @param int $userId
     * @return mixed
     */
    public function getUnparsedTextForStatementsByUserId(int $userId): TextForStatementData
    {
        return TextForStatementsEloquent::where(['is_parsed' => 0], ['user_id' => $userId])->first();
    }


    /**
     * Отметить текст как распарсенный
     * @param int $textId
     * @return mixed
     */
    public function markTextParsed(int $textId){
        return TextForStatementsEloquent::where('id', $textId)->update(['is_parsed' => 1]);
    }

    /**
     * @param int $textId
     * @return mixed
     */
    public function getTextForStatementsByTextId(int $textId): TextForStatementData{
        $textForStatement = TextForStatementsEloquent::where(['id' => $textId])->first();

        $textForStatementData = new TextForStatementData($textForStatement->id, $textForStatement->userId, $textForStatement->text);

        return $textForStatementData;
    }
}
