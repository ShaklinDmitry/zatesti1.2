<?php

namespace App\Modules\Statements\Application\DTOs;

class StatementDTO
{

    public function __construct(public string $guid, public int $userId, public string $text)
    {
    }
}
