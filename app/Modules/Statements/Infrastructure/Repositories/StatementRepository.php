<?php

namespace App\Modules\Statements\Infrastructure\Repositories;

use App\Modules\Statements\Domain\StatementRepositoryInterface;
use App\Modules\Statements\Infrastructure\DTOs\StatementDTO;
use App\Modules\Statements\Infrastructure\DTOs\StatementDTOCollection;
use App\Exceptions\NoStatementsException;
use App\Exceptions\NoStatementsForSendingException;
use App\Models\StatementEloquent;

class StatementRepository implements StatementRepositoryInterface
{
    /**
     * Добавить новое высказывание.
     * @param int $userId
     * @param string $text
     * @return StatementDTO
     */
    public function createStatement(int $userId, string $text): StatementDTO
    {
        $statement = StatementEloquent::create(
            [
                'user_id' => $userId,
                'text' => $text
            ]
        );

        $statementData = new StatementDTO($statement->id, $statement->userId, $statement->text);

        return $statementData;
    }

    /**
     * Получить высказывания для отправки.
     * @param int $userId
     * @return StatementDTO
     * @throws NoStatementsForSendingException
     */
    public function getStatementForSendingByUserId(int $userId): StatementDTO
    {
        $statement = StatementEloquent::where('user_id', $userId)
            ->where('send_date_time', '1970-01-01 00:00:00')
            ->where('text','<>','')
            ->first();


        if($statement == null){
            throw new NoStatementsForSendingException('There are no statements to send to the user',0,
                null,['userId' => $userId]);
        }

        $statementData = new StatementDTO(id: $statement->id, userId: $statement->userId, text: $statement->text);

        return $statementData;
    }


    /**
     * Функция для получения высказывний.
     * @param int $userId
     * @return StatementDTOCollection
     * @throws NoStatementsException
     */
    public function getAllStatementsByUserId(int $userId): StatementDTOCollection
    {
        $statements = StatementEloquent::where('user_id', $userId)->get();

        if($statements->isEmpty()){
            throw new NoStatementsException('No statements', 200);
        }

        $statementDataCollection = new StatementDTOCollection();
        foreach ($statements as $statement){
            $statementData = new StatementDTO(id: $statement->id, userId: $statement->userId, text: $statement->text);
            $statementDataCollection->addStatementData($statementData);
        }

        return $statementDataCollection;
    }

    /**
     * Установить дату отправки выскаывания.
     * @param int $statementId
     * @return bool
     */
    public function setStatementSendDateTime(int $statementId): bool
    {
        return StatementEloquent::where('id',$statementId)->update(['send_date_time' => NOW()]);
    }
}
