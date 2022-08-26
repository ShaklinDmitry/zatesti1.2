<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    use HasFactory;

    protected $table = 'user_response';

    /**
     * Для сохранения текста ответа пользователя
     * @param string $text
     * @param int $message_id
     * @return bool
     */
    public function saveUserResponse(string $text, int $message_id){
        $this->text = $text;
        $this->message_id = $message_id;

        $saveResponseResult = $this->save();
        return $saveResponseResult;
    }


}
