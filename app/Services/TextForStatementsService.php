<?php

namespace App\Services;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatements;


class TextForStatementsService
{

    public function __construct(private TextForStatements $textForStatements){}


    /**
     * Функуия возвращает массив высказываний, которые получаются после парсинга текста
     *
     * @return array
     * @throws TextForStatementsIsNullException
     */
    public function makeStatements(){

        $textNotSeparatedIntoStatements = $this->textForStatements->select('*')->where(
            [
                ['is_parsed', '=', '0']
            ]
        )->first();

        if($textNotSeparatedIntoStatements == null){
            throw new TextForStatementsIsNullException();
        }

        $statementsAfterSeparatingTextWithSpecialSign = explode(".", $textNotSeparatedIntoStatements);

        return $statementsAfterSeparatingTextWithSpecialSign;
    }

    /**
     * Для добавления нового текста в БД
     * @param $text
     * @return bool
     */
    public function addText(string $text): bool{
        $this->textForStatements->text = $text;
        $saveTextResult = $this->textForStatements->save();
        return $saveTextResult;
    }

}
