<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatementSendingSchedule extends Model
{
    use HasFactory;

    protected $table = 'send_statements_schedule';

    protected $fillable = [
        'user_id',
        'exact_time'
    ];

}
