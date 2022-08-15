<?php

namespace App\Services;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\Text;


class TextService
{

    public function __construct(private Text $text){}


    /**
     * Функуия возвращает массив высказываний, которые получаются после парсинга текста
     *
     * @return array
     * @throws TextForStatementsIsNullException
     */
    public function makeStatements(){
        $textNotSeparatedIntoStatements = $this->text->getNotParsedText();

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
    public function addText($text){
        $result = $this->text->addText($text);
        return $result;
    }

}
