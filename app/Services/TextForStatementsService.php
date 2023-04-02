<?php

namespace App\Services;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatements;
use Illuminate\Database\Eloquent\Model;


class TextForStatementsService
{

    public function __construct(){}


    /**
     * Функция для возврата текста, который еще не был распарсен
     * @return TextForStatements|null
     * @throws TextForStatementsIsNullException
     */
    public function getUnparsedTextForUser(int $userId):TextForStatements{
        $unParsedText = TextForStatements::where(['is_parsed' => 0], ['user_id' => $userId])->first();

        if($unParsedText == null){
            throw new TextForStatementsIsNullException();
        }

        return $unParsedText;
    }

    /**
     * Функуия сохраняет массив высказываний, которые получаются после парсинга текста
     * @param int $userId
     * @return void
     * @throws TextForStatementsIsNullException
     */
    public function makeStatementsForUser(int $userId): void {

        $unParsedText = $this->getUnparsedTextForUser($userId);

        $statements = $this->parseTextIntoStatements($unParsedText['text']);

        $this->markTextAsParsed($unParsedText['id']);

        $statementService = new StatementService();
        foreach ($statements as $text){
            $statementService->addStatement($text, $userId);
        }
    }

    /**
     * Функция разбиения текста на высказывания
     * @param string $text
     * @return string[]
     */
    private function parseTextIntoStatements(string $text){

        $statements = explode(".", $text);

        return $statements;
    }

    /**
     * Функция для того чтобы отметить что текст был распарсен
     * @param int $textId
     * @return bool
     */
    public function markTextAsParsed(int $textId){

        $markTextResult = TextForStatements::where('id', $textId)->update(['is_parsed' => 1]);

        return $markTextResult;
    }


    /**
     *  Для добавления нового текста в БД
     * @param string $text
     * @param int $userId
     * @return TextForStatements
     */
    public function addText(string $text, int $userId):TextForStatements{
        $text = TextForStatements::create([
            'text' => $text,
            'user_id' => $userId
        ]);

        return $text;
    }

}
