<?php

namespace App\Modules\Text\Infrastructure\Repositories;


use App\Models\TextForStatementsEloquent;
use App\Modules\Text\Application\DTO\TextForStatementDTO;
use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

class TextForStatementsRepository implements TextForStatementsRepositoryInterface
{
    /**
     * Функция для возврата нераспарсенного текста
     * @param int $userId
     * @return mixed
     */
    public function getUnparsedTextForStatementsByUserId(int $userId): TextForStatementDTO
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
    public function getTextForStatementsByTextId(int $textId): TextForStatementDTO{
        $textForStatement = TextForStatementsEloquent::where(['id' => $textId])->first();

        $textForStatementData = new TextForStatementDTO($textForStatement->id, $textForStatement->userId, $textForStatement->text);

        return $textForStatementData;
    }

    /**
     * Функция для сохранения текста для высказываний
     * @param int $userId
     * @param string $text
     * @return TextForStatementDTO
     */
    public function saveTextForStatements(string $guid, int $userId, string $text): TextForStatementDTO
    {
        $text = TextForStatementsEloquent::create([
            'guid' => $guid,
            'text' => $text,
            'user_id' => $userId
        ]);

        $textForStatementDTO = new  TextForStatementDTO(guid: $text->guid, userId: $text->userId, text: $text->text);

        return $textForStatementDTO;

    }
}
