<?php

namespace App\Modules\User\Application;

use App\Modules\User\Application\DTO\UserDTO;

interface UserServiceInterface
{
    public function getUserById(): UserDTO;
}
