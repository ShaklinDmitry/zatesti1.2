<?php

namespace App\Domains\BestStatements;

use App\Domains\BestStatements\Exceptions\NoBestStatementsToDeleteException;
use App\Models\BestStatement;

class DeleteBestStatementCommand
{

    /**
     * Функция для удаления лучших высказываний
     * @param int $id
     * @return bool
     */
    public function execute(int $bestStatementId):bool{
        $bestStatement = BestStatement::where('id', $bestStatementId)->first();

        if($bestStatement == null){
            throw new NoBestStatementsToDeleteException();
        }

        return $bestStatement->delete();
    }
}
