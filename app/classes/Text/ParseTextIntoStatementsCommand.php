<?php

namespace App\classes\Text;

class ParseTextIntoStatementsCommand
{
    /**
     * Функция разбиения текста на высказывания
     * @param string $text
     * @return string[]
     */
    public function execute(string $text){
        $statements = explode(".", $text);
        return $statements;
    }
}
