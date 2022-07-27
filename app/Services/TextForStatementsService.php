<?php

namespace App\Services;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatements;


class TextForStatementsService
{

    /**
     *Разделить текст на предложения
     * @return array
     * @throws TextForStatementsIsNullException
     */
    public function getStatements(){
        $textForParsing = new TextForStatements();

        $text = $textForParsing->getText();

        if($text == null){
            throw new TextForStatementsIsNullException();
        }

        $statements = explode(".", $text->text);
        return $statements;
    }

}
