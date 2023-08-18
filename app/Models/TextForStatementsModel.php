<?php

namespace App\Models;

use App\Exceptions\TextForStatementsIsNullException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextForStatementsModel extends Model
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
