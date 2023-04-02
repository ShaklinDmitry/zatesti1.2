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

    protected $fillable = [
        'text',
        'user_id',
    ];

    /**
     * Сохранение в БД текста высказывания
     * @param Request $request
     * @return bool
     */
    public function add(string $text, int $userId){
        $this->text = $text;
        $this->user_id = $userId;
        $result = $this->save();
        return $result;
    }

}
