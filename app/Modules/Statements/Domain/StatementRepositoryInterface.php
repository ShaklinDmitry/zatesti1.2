<?php

namespace App\Modules\Statements\Domain;

use App\Modules\Statements\Infrastructure\DTOs\StatementDTO;
use App\Modules\Statements\Infrastructure\DTOs\StatementDTOCollection;

interface StatementRepositoryInterface
{
    /**
     * Добавить новое высказывание
     * @param int $userId
     * @param string $text
     * @return StatementDTO
     */
    public function createStatement(int $userId, string $text): StatementDTO;

    /**
     * получить высказывания для отправления пользователям
     * @param int $userId
     * @return StatementDTO
     */
    public function getStatementForSendingByUserId(int $userId): StatementDTO;

    /**
     * получить все высказывания по id по usedId
     * @param int $userId
     * @return StatementDTOCollection
     */
    public function getAllStatementsByUserId(int $userId): StatementDTOCollection;

    /**
     * для установки времени отправки высказывания
     * @return mixed
     */
    public function setStatementSendDateTime(int $statementId);
}