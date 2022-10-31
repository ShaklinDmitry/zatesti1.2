<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * Функция для создания пользователя
     * @param $user
     * @return User|null
     */
    public function createUser($user){
        $user = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);
        return $user;
    }

}
