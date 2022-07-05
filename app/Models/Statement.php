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
    public function add(string $text){
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


    /**
     * Удалить элемент по id
     * @param $id
     * @return bool|void|null
     */
    public function deleteItem($id){
        return $this->select('*')->where([
            ['id', '=', $id]
        ])->delete();

    }


    /**
     * Получить высказывание, которое еще не было отправлено
     * @return model
     */
    public function getNotSendedStatement(){
        return $this->select('*')->where(
            [
                ['send_date_time', '=', '1970-01-01 00:00:00']
            ]
        )->first();
    }


    /**
     *  Отметить время отправки высказывания
     *
     * @param $id
     * @return mixed
     */
    public function markSendedStatement($id){
        return $this->where(
            [
                ['id', '=', $id]
            ]
        )->update(['send_date_time' => NOW()]);
    }

}
