<?php

namespace App\classes\UserResponses\Models;

use App\classes\UserResponses\Interfaces\UserResponseInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    use HasFactory;

    protected $table = 'user_response';

    protected $fillable = [
        'telegram_chat_id',
        'user_id',
        'text'
    ];

}
