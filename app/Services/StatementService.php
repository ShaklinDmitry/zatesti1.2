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
    public function getStatements(int $userId){
        $statements = Statement::where('user_id', $userId)->get();
        return $statements;
    }

    /**
     * Добавить высказывание в БД
     * @param $text
     * @return bool
     */
    public function addStatement($text, int $userId){
        $statement = new Statement();
        $addStatementResult = $statement->add($text, $userId);
        return $addStatementResult;
    }


    /**
     * Функция для получения высказываний для отправки пользователю
     * @param int $userId
     * @return mixed
     */
    public function getStatementForSending(int $userId){
        $statement = Statement::where('user_id', $userId)
                                ->where('send_date_time', '1970-01-01 00:00:00')
                                ->first();

        return $statement;
    }
}
