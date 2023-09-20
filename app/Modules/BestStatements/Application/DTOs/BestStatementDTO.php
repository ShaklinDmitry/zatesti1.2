<?php

namespace App\Modules\BestStatements\Application\DTOs;

class BestStatementDTO
{

    public function __construct(public int $id, public string $text, public int $userId)
    {
    }
}
