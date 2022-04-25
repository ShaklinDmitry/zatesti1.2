<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;

    protected $table = 'statement';

    /**
     * Сохранение в БД текста высказывания
     * @param Request $request
     * @return bool
     */
    public function add(Request $text){
        $this->text = $text;
        $result = $this->save();
        return $result;
    }


    /**
     * Получить все высказывания
     * @return Collection
     */
    public function getAll(){
        return $this->all();
    }
}
