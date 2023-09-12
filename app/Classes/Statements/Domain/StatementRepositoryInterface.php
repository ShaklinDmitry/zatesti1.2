<?php

namespace App\Classes\Statements\Domain;

use App\Classes\Statements\Infrastructure\DTO\StatementData;
use App\Classes\Statements\Infrastructure\DTO\StatementDataCollection;

interface StatementRepositoryInterface
{
    /**
     * Добавить новое высказывание
     * @param int $userId
     * @param string $text
     * @return StatementData
     */
    public function createStatement(int $userId, string $text): StatementData;

    /**
     * получить высказывания для отправления пользователям
     * @param int $userId
     * @return StatementData
     */
    public function getStatementForSendingByUserId(int $userId): StatementData;

    /**
     * получить все высказывания по id по usedId
     * @param int $userId
     * @return StatementDataCollection
     */
    public function getAllStatementsByUserId(int $userId): StatementDataCollection;
}
