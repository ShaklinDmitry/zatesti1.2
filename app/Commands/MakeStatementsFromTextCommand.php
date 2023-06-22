<?php

namespace App\Commands;

use App\Services\StatementService;

class MakeStatementsFromTextCommand
{

    /**
     * Функуия сохраняет массив высказываний, которые получаются после парсинга текста
     * @param int $userId
     * @return void
     * @throws \App\Exceptions\TextForStatementsIsNullException
     */
    public function execute(int $userId){
        $getUnparsedTextForUser = new GetUnparsedTextForStatementsCommand();
        $unparsedText = $getUnparsedTextForUser->execute($userId);

        $parseTextIntoStatements = new ParseTextIntoStatementsCommand();
        $statements = $parseTextIntoStatements->execute($unparsedText->text);

        $markTextAsParsed = new MarkTextAsParsedCommand();
        $markTextAsParsed->execute($unparsedText['id']);

        $addStatement = new AddStatementCommand();
        foreach ($statements as $text){
            $addStatement->execute($text, $userId);
        }
    }
}
