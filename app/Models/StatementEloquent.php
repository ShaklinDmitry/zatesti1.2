<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatementEloquent extends Model
{
    use HasFactory;

    protected $table = 'statement';

    protected $fillable = [
        'guid',
        'text',
        'user_id',
    ];

}
