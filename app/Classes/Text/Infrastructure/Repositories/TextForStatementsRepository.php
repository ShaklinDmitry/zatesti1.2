<?php

namespace App\Classes\Text\Infrastructure\Repositories;


use App\Classes\Text\Domain\TextForStatementsRepositoryInterface;
use App\Classes\Text\Infrastructure\DTO\TextForStatementData;
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

    /**
     * Функция для сохранения текста для высказываний
     * @param int $userId
     * @param string $text
     * @return TextForStatementData
     */
    public function saveTextForStatements(int $userId, string $text): TextForStatementData
    {
        $text = TextForStatementsEloquent::create([
            'text' => $text,
            'user_id' => $userId
        ]);

        $textForStatementData = new  TextForStatementData(id: $text->id, userId: $text->userId, text: $text->text);

        return $textForStatementData;

    }
}
