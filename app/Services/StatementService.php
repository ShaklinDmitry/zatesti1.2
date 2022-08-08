<?php

namespace App\Services;

use App\Models\Statement;

class StatementService
{

    /**
     * Функция сохранения высказываний в БД
     * @param array $statements
     */
    public function saveStatements(array $statements){
        foreach ($statements as $statement){
            $statement = new Statement();
            $statement->add($statement);
        }
    }

}
