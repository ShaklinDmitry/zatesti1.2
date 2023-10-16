<?php

namespace App\Modules\Text\Application\DTO;

class TextForStatementDTO
{

    public function __construct(public string $guid, public int $userId, public string $text)
    {

    }


}
