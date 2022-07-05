<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextForParsingIntoStatements extends Model
{
    use HasFactory;

    protected $table = 'table_for_the_text_that_will_be_parsed_into_statements';

    /**
     * Добавить текст для последующего его парсинга
     * @param $text
     * @return mixed
     */
    public function addText($text){
        $this->text = $text;
        $result = $this->save();
        return $result;
    }


    /**
     * Получить текст для парсинга
     * @return mixed
     */
    public function getText(){
        return $this->select('*')->where(
            [
                ['is_parsed', '=', '0']
            ]
        )->first();
    }
}
