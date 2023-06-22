<?php

namespace App\Commands;

use App\Models\Statement;

class AddStatementCommand
{
    /**
     * Добавить высказывание
     * @param string $text
     * @param int $userId
     * @return Statement
     */
    public function execute(string $text, int $userId):Statement{

        $statement = Statement::create([
            'user_id' => $userId,
            'text' => $text
        ]);

        return $statement;
    }
}
