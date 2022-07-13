<?php

namespace App\Services;

use App\Models\TextForSplitIntoStatements;

class SplitTextIntoStatementsService
{

    /**
     *
     * @return void
     */
    public function getStatements(){
        $textForParsing = new TextForSplitIntoStatements();

        $text = $textForParsing->getText();

        return $text;
    }

}
