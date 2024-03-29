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
        $textForStatement = TextForStatementsEloquent::where(['is_parsed' => 0], ['user_id' => $userId])->first();

        $textForStatementDTO = new TextForStatementDTO($textForStatement->guid, $textForStatement->user_id, $textForStatement->text);

        return $textForStatementDTO;
    }


    /**
     * Отметить текст как распарсенный.
     * @param string $guid
     * @return mixed
     */
    public function markTextParsed(string $guid){
        return TextForStatementsEloquent::where('guid', $guid)->update(['is_parsed' => 1]);
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

        $textForStatementDTO = new  TextForStatementDTO(guid: $text->guid, userId: $text->user_id, text: $text->text);

        return $textForStatementDTO;

    }
}
