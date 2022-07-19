<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextForStatements extends Model
{
    use HasFactory;

    protected $table = 'table_for_the_text_that_will_be_parsed_into_statements';

    /**
     * Добавить текст для последующего его парсинга
     * @param $text
     * @return bool
     */
    public function addText($text){

        if(is_null($text)){
            return false;
        }
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
