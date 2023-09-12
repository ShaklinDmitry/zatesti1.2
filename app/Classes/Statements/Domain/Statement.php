<?php

namespace App\Classes\Statements\Domain;

class Statement implements StatementInterface
{
    /**
     * @param int $id
     * @param int $userId
     * @param string $text
     */
    public function __construct(public int $id, public int $userId, public string $text)
    {
    }

}
