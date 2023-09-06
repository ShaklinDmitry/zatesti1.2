<?php

namespace App\classes\Statements;

use App\Models\StatementEloquent;

class AddStatementCommand
{
    /**
     * Добавить высказывание
     * @param string $text
     * @param int $userId
     * @return \App\classes\Statements\Domain\Statement
     */
    public function execute(string $text, int $userId):StatementEloquent{

        $statement = StatementEloquent::create([
            'user_id' => $userId,
            'text' => $text
        ]);

        return $statement;
    }
}
