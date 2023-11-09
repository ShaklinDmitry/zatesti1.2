<?php

namespace App\Modules\User\Application\UseCases;


use App\Modules\User\Domain\UserNotifyServiceInterface;
use App\Modules\User\Domain\UserRepositoryInterface;

class UserNotifyCommand implements UserNotifyCommandInterface
{

    /**
     * @param UserNotifyServiceInterface $userNotifyService
     */
    public function __construct(private UserNotifyServiceInterface $userNotifyService)
    {
    }

    /**
     * @param int $userId
     * @param string $text
     * @return void
     */
    public function execute(int $userId, string $text, string $statementGuid){
        $this->userNotifyService->notifyUser($userId, $text, $statementGuid);
    }
}
