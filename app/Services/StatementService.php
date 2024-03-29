<?php

namespace App\Services;

use App\Exceptions\NoStatementsException;
use App\Models\BestStatementEloquent;
use App\Models\StatementEloquent;
use Illuminate\Database\Eloquent\Collection;

class StatementService
{

    /**
     * Функция для отправки высказываний(через job)
     * @param string $sendTime
     * @return void
     * @throws \Exception
     */
//    public function sendStatements(string $sendTime, StatementNotificationSystemInterface $statementNotification){
//        try{
//
//
//            SendStatements::dispatch($users, $statementNotification);
//        }catch (\Exception $exception){
//          //  Log::info($exception->getMessage());
//        }
//    }

//    /**
//     * Функция сохранения высказываний в БД
//     * @param array $statements
//     */
//    public function saveStatements(array $statements, int $user_id){
//        foreach ($statements as $statementText){
//            $statement = new StatementEloquent();
//            $statement->add($statementText, $user_id);
//        }
//    }


    /**
     * Для получения высказываний
     * @param int $userId
     * @return Collection
     * @throws NoStatementsException
     */
//    public function getStatements(int $userId):Collection{
//        $statements = StatementEloquent::where('user_id', $userId)->get();
//
//        if($statements->isEmpty()){
//            throw new NoStatementsException('No statements', 200);
//        }
//
//        return $statements;
//    }

    /**
     * Добавить высказывание в базу
     * @param string $text
     * @param int $userId
     * @return StatementEloquent
     */
//    public function addStatement(string $text, int $userId):StatementEloquent {
//
//            $statement = StatementEloquent::create([
//                'user_id' => $userId,
//                'text' => $text
//            ]);
//
//            return $statement;
//
//    }


    /**
     * Функция для получения высказываний для отправки пользователю
     * @param int $userId
     * @return mixed
     */
//    public function getStatementForSending(int $userId){
//        $statement = StatementEloquent::where('user_id', $userId)
//                                ->where('send_date_time', '1970-01-01 00:00:00')
//                                ->where('text','<>','')
//                                ->first();
//
//
//        if($statement == null){
//            throw new NoStatementsForSendingException('There are no statements to send to the user',0,null,['userId' => $userId]);
//        }
//
//        return $statement;
//    }

    /**
     * Отметить время отправки высказывания
     * @param int $statementId
     * @return mixed
     */
//    public function markStatementHasBeenSent(int $statementId){
//
//        return StatementEloquent::where('id',$statementId)->update(['send_date_time' => NOW()]);
//
//    }


    /**
     * Удалить высказывание
     * @param int $id
     * @return bool
     */
    public function deleteStatement(int $id): bool {
        return StatementEloquent::where('id', $id)->delete();
    }

    /**
     * сделать высказывание "лучшим"
     * @param int $userId
     * @return BestStatementEloquent
     */
//    public function transferStatementToBestStatements(StatementEloquent $statement){
//        $newBestStatement = BestStatementEloquent::create([
//            'user_id' => $statement->user_id,
//            'text' => $statement->text
//        ]);
//
//        return $newBestStatement;
//    }

}
