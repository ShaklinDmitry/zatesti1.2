<?php

namespace App\Commands;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatements;

class GetUnparsedTextForStatementsCommand
{
    /**
     * Функция для получения текста, который еще не был распарсен на высказывания
     * @param int $userId
     * @return TextForStatements|null
     * @throws TextForStatementsIsNullException
     */
    public function execute(int $userId){
        $unParsedText = TextForStatements::where(['is_parsed' => 0], ['user_id' => $userId])->first();

        if($unParsedText == null){
            throw new TextForStatementsIsNullException();
        }

        return $unParsedText;
    }
}
