<?php

namespace App\Domains\BestStatements;

use App\Domains\BestStatements\Exceptions\NoBestStatementsForUserException;
use App\Models\BestStatement;
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
