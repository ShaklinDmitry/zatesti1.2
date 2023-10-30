<?php

namespace App\Modules\User\Domain;

interface UserRepositoryInterface
{
    /**
     * @param int $userId
     * @param int $statementId
     * @return mixed
     */
    public function saveIdOfLastSentStatement(int $userId, int $statementId);

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserById(int $userId);
}
