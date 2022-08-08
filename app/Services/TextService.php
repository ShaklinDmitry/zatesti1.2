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
        $statementsAfterSeparatingTextWithSpecialSign = $this->explodeText($textNotSeparatedIntoStatements);

        return $statementsAfterSeparatingTextWithSpecialSign;
    }

    /**
     *Разделить текст на предложения
     * @return array
     * @throws TextForStatementsIsNullException
     */
    public function explodeText(string $text): array{

        $result = explode(".", $text);

        return $result;
    }

}
