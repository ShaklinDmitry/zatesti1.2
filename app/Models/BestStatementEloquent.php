<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestStatementEloquent extends Model
{
    use HasFactory;

    protected $table = 'best_statements';

    protected $fillable = [
        'text',
        'user_id',
    ];
}
