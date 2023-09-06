<?php

namespace App\classes\Statements;

use App\Models\StatementEloquent;

class StatementSentStatusUpdater
{
    /**
     * Отметить время отправки высказывания
     * @param int $statementId
     * @return mixed
     */
    public function setSentStatusTrue(int $statementId){
        return StatementEloquent::where('id',$statementId)->update(['send_date_time' => NOW()]);
    }
}
