<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextForParsingIntoStatements extends Model
{
    use HasFactory;

    protected $table = 'table_for_the_text_that_will_be_parsed_into_statements';

    public function addText($text){
        $this->text = $text;
        $result = $this->save();
        return $result;
    }

}
