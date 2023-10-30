<?php

namespace App\Modules\User\Application\UseCases;

interface UserNotifyCommandInterface
{
    /**
     * @return mixed
     */
    public function execute(int $userId, string $text);
}
