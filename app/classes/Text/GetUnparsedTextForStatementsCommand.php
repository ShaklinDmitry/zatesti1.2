<?php

namespace App\classes\Text;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatementsModel;

class GetUnparsedTextForStatementsCommand
{
    /**
     * Функция для получения текста, который еще не был распарсен на высказывания
     * @param int $userId
     * @return TextForStatementsModel|null
     * @throws TextForStatementsIsNullException
     */
//    public function execute(int $userId){
//        $unParsedText = TextForStatementsModel::where(['is_parsed' => 0], ['user_id' => $userId])->first();
//
//        if($unParsedText == null){
//            throw new TextForStatementsIsNullException();
//        }
//
//        return $unParsedText;
//    }
}
