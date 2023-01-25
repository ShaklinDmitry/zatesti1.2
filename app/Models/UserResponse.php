<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    use HasFactory;

    protected $table = 'user_response';

    protected $fillable = [
        'telegram_chat_id',
        'text'
    ];

}
