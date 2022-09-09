<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextForStatements extends Model
{
    use HasFactory;

    protected $table = 'table_for_the_text_that_will_be_parsed_into_statements';
}
