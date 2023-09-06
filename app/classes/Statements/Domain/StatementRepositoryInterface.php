<?php

namespace App\classes\Statements\Domain;

use App\classes\Statements\Infrastructure\DTO\StatementData;

interface StatementRepositoryInterface
{
    /**
     * Добавить новое высказывание
     * @param int $userId
     * @param string $text
     * @return StatementData
     */
    public function createStatement(int $userId, string $text): StatementData;
}
