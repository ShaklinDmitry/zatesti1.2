<?php

namespace App\Services;

use App\Models\TextForParsingIntoStatements;

class ParseTextForStatementsService
{

    /**
     *
     * @return void
     */
    public function parseText(){
        $textForParsing = new TextForParsingIntoStatements();

        $text = $textForParsing->getText();

        dd($text);


    }

}
