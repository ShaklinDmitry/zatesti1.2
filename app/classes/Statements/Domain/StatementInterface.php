<?php

namespace App\classes\Statements\Domain;

use App\Models\StatementEloquent;

interface StatementInterface
{
    /**
     * Добавить новое высказывание
     * @param int $userId
     * @param string $text
     * @return mixed
     */
    public function addStatement(int $userId, string $text);
}
