<?php

namespace App\Domains\Notifications;

use App\Models\User;

class SaveIdOfLastSentStatementCommand
{

    /**
     * Ф-ия для сохранения в БД id последнего отправленного высказывания
     * @param int $userId
     * @param int $statementId
     * @return void
     */
    public function execute(int $userId, int $statementId){
        $user = User::find($userId);
        $user->last_statement_id_sent = $statementId;
        $user->save();
    }
}
