<?php

namespace App\classes\UserResponses\Interfaces;

use App\Models\User;

interface UserResponseInterface
{
    public function save(User $user, string $userResponseText);
}
