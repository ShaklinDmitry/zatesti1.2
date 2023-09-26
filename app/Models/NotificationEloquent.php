<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEloquent extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'sended_notification_text',
        'user_id',
    ];
}
