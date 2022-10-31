<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextForStatements extends Model
{
    use HasFactory;

    protected $table = 'text';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text','user_id'];
}
