<?php

namespace App\classes\BestStatements;

use App\classes\BestStatements\Exceptions\NoBestStatementsForUserException;
use App\classes\BestStatements\Models\BestStatement;
use Illuminate\Database\Eloquent\Collection;

class GetBestStatementsCommand
{

    /**
     * Функция для получения лучших высказываний
     * @param int $userId
     * @return BestStatement
     * @throws \Exception
     */
    public function execute(int $userId):Collection{
        $bestStatements = BestStatement::select('id', 'text')->where('user_id', $userId)->get();

        if($bestStatements->isEmpty()){
            throw new NoBestStatementsForUserException();
        }

        return $bestStatements;
    }
}
