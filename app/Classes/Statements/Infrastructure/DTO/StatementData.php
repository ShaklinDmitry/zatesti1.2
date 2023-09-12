<?php

namespace App\Classes\Statements\Infrastructure\DTO;

class StatementData
{

    public function __construct(public int $id, public int $userId, public string $text)
    {
    }
}
