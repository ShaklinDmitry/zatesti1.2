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

        try{
            $text = $textForParsing->getText();
        }catch(Exception $e){
            print_r($e);
        }

        $statements = explode(".", $text->text);

        return $statements;
    }

}
