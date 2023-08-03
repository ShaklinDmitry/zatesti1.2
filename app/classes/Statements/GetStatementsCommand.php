<?php

namespace App\classes\Statements;

use App\Exceptions\NoStatementsException;
use App\Models\Statement;
use Illuminate\Database\Eloquent\Collection;

class GetStatementsCommand
{
    /**
     * Функция для получения высказываний по определенному userId
     * @param int $userId
     * @return Collection
     * @throws NoStatementsException
     */
    public function execute(int $userId):Collection{
        $statements = Statement::where('user_id', $userId)->get();

        if($statements->isEmpty()){
            throw new NoStatementsException('No statements', 200);
        }

        return $statements;
    }
}
