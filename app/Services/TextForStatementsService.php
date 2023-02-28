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
    public function getUnparsedText(int $userId){
        $unParsedText = TextForStatements::where(['is_parsed' => 0], ['user_id' => $userId])->first();

        if($unParsedText == null){
            throw new TextForStatementsIsNullException();
        }

        return $unParsedText;
    }

    /**
     * Функуия сохраняет массив высказываний, которые получаются после парсинга текста
     *
     * @return bool
     * @throws TextForStatementsIsNullException
     */
    public function makeStatements(int $userId){

        $unParsedText = $this->getUnparsedText($userId);

        $statements = $this->parseTextIntoStatements($unParsedText['text']);

        $resultOfMarkTextAsParsed = $this->markTextAsParsed($unParsedText['id']);

        $statementService = new StatementService();

        $resultOfSaveStatements = $statementService->saveStatements($statements, $unParsedText['user_id']);

        return $resultOfSaveStatements;
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
     * @param int $id
     * @return bool
     */
    public function markTextAsParsed(int $id){

        $markTextResult = TextForStatements::where('id', $id)->update(['is_parsed' => 1]);

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
