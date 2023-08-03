<?php

namespace App\classes\Statements;

use App\Models\Statement;

class StatementSentStatusUpdater
{
    /**
     * Отметить время отправки высказывания
     * @param int $statementId
     * @return mixed
     */
    public function setSentStatusTrue(int $statementId){
        return Statement::where('id',$statementId)->update(['send_date_time' => NOW()]);
    }
}
