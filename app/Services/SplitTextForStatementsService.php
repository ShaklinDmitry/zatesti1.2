<?php

namespace App\Services;

use App\Models\TextForSplitIntoStatements;

class SplitTextForStatementsService
{

    /**
     *
     * @return void
     */
    public function getStatements(){
        $textForParsing = new TextForSplitIntoStatements();

        $text = $textForParsing->getText();

        dd($text);


    }

}
