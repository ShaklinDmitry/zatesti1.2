<?php

namespace App\Modules\Statements\Domain;

use App\Modules\Statements\Application\DTOs\StatementDTO;
use App\Modules\Statements\Application\DTOs\StatementDTOCollection;

interface StatementRepositoryInterface
{
    /**
     * Добавить новое высказывание
     * @param string $guid
     * @param int $userId
     * @param string $text
     * @return StatementDTO
     */
    public function createStatement(string $guid, int $userId, string $text): StatementDTO;

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
     * @param string $statementGuid
     * @return mixed
     */
    public function setStatementSendDateTime(string $statementGuid);
}
