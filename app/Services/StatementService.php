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
        foreach ($statements as $statementText){
            $statement = new Statement();
            $statement->add($statementText);
        }
    }


    /**
     * Для получения высказываний
     * @param Statement $statement
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStatements(){
        $statement = new Statement();
        $statements = $statement->getAll();
        return $statements;
    }
}
