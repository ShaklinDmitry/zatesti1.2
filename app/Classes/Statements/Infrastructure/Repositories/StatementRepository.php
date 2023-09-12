<?php

namespace App\Classes\Statements\Infrastructure\Repositories;

use App\Classes\Statements\Domain\StatementRepositoryInterface;
use App\Classes\Statements\Infrastructure\DTO\StatementData;
use App\Classes\Statements\Infrastructure\DTO\StatementDataCollection;
use App\Exceptions\NoStatementsException;
use App\Exceptions\NoStatementsForSendingException;
use App\Models\StatementEloquent;

class StatementRepository implements StatementRepositoryInterface
{
    /**
     * Добавить новое высказывание
     * @param int $userId
     * @param string $text
     * @return StatementData
     */
    public function createStatement(int $userId, string $text): StatementData
    {
        $statement = StatementEloquent::create(
            [
                'user_id' => $userId,
                'text' => $text
            ]
        );

        $statementData = new StatementData($statement->id, $statement->userId, $statement->text);

        return $statementData;
    }

    /**
     * Получить высказывания для отправки
     * @param int $userId
     * @return StatementData
     * @throws NoStatementsForSendingException
     */
    public function getStatementForSendingByUserId(int $userId): StatementData
    {
        $statement = StatementEloquent::where('user_id', $userId)
            ->where('send_date_time', '1970-01-01 00:00:00')
            ->where('text','<>','')
            ->first();


        if($statement == null){
            throw new NoStatementsForSendingException('There are no statements to send to the user',0,
                null,['userId' => $userId]);
        }

        $statementData = new StatementData(id: $statement->id, userId: $statement->userId, text: $statement->text);

        return $statementData;
    }


    /**
     * Функция для получения высказывний
     * @param int $userId
     * @return StatementDataCollection
     * @throws NoStatementsException
     */
    public function getAllStatementsByUserId(int $userId): StatementDataCollection
    {
        $statements = StatementEloquent::where('user_id', $userId)->get();

        if($statements->isEmpty()){
            throw new NoStatementsException('No statements', 200);
        }

        $statementDataCollection = new StatementDataCollection();
        foreach ($statements as $statement){
            $statementData = new StatementData(id: $statement->id, userId: $statement->userId, text: $statement->text);
            $statementDataCollection->addStatementData($statementData);
        }

        return $statementDataCollection;
    }
}
