<?php

namespace App\Modules\Text\Infrastructure\DTO;

class TextForStatementData
{

    public function __construct(public int $id, public int $userId, public string $text)
    {

    }


}
