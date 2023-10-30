<?php

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\UserRepositoryInterface;

class SaveIdOfLastSentStatementUseCase
{

    /**
     * @param int $userId
     * @param int $statementId
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(private int $userId, private int $statementId, private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @return void
     */
    public function execute(){
        $this->userRepository->saveIdOfLastSentStatement($this->userId, $this->statementId);
    }
}
