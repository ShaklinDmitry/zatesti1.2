<?php

namespace App\Modules\User\Infrastructure\Repositories;

use App\Models\User;
use App\Modules\User\Domain\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Cохранить последнее отправленное высказывание
     * @param int $userId
     * @param int $statementId
     * @return void
     */
    public function saveIdOfLastSentStatement(int $userId, int $statementId){
        $user = User::find($userId);
        $user->last_statement_id_sent = $statementId;
        $user->save();
    }
}
