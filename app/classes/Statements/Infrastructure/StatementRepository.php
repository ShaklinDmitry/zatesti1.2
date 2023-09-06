<?php

namespace App\classes\Statements\Infrastructure;

use App\classes\Statements\Domain\StatementRepositoryInterface;
use App\classes\Statements\Infrastructure\DTO\StatementData;
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
}
