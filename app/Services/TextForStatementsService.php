<?php

namespace App\Services;

use App\Models\TextForStatements;

class TextForStatementsService
{

    /**
     *Разделить текст на предложения
     * @return array
     */
    public function getStatements(){
        $textForParsing = new TextForStatements();

        $text = $textForParsing->getText();

        $statements = explode(".", $text->text);

        return $statements;
    }

}
