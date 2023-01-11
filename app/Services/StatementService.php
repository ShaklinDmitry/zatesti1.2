<?php

namespace App\Services;

use App\Jobs\SendStatements;
use App\Models\Statement;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class StatementService
{

    /**
     * Функция для отправки высказываний(через job)
     * @param string $sendTime
     * @return void
     * @throws \Exception
     */
    public function sendStatements(string $sendTime){
        try{
            $statementScheduleService = new StatementScheduleService();
            $usersIds = $statementScheduleService->getUserIdsWhoShouldBeNotifiedAtTheCurrentTime($sendTime);



            SendStatements::dispatch($usersIds);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

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
                                ->where('text','<>','')
                                ->first();


        if($statement == null){
            throw new \Exception('There are no statements to send to the user');
        }

        return $statement;
    }

    /**
     * Отметить время отправки высказывания
     * @param int $statementId
     * @return mixed
     */
    public function markStatementHasBeenSent(int $statementId){

        return Statement::where('id',$statementId)->update(['send_date_time' => NOW()]);

    }
}
