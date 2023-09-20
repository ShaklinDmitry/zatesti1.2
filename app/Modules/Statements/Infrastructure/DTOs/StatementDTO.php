<?php

namespace App\Modules\Statements\Infrastructure\DTOs;

class StatementDTO
{

    public function __construct(public int $id, public int $userId, public string $text)
    {
    }
}
