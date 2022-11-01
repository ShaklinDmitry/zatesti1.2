<?php

namespace App\Services;

use App\Models\Statement;

class StatementService
{

    /**
     * Функция сохранения высказываний в БД
     * @param array $statements
     */
    public function saveStatements(array $statements, int $user_id){
        foreach ($statements as $statementText){
            $statement = new Statement();
            $statement->add($statementText, $user_id);
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

    /**
     * Добавить высказывание в БД
     * @param $text
     * @return bool
     */
    public function addStatement($text){
        $statement = new Statement();
        $addStatementResult = $statement->add($text);
        return $addStatementResult;
    }
}
