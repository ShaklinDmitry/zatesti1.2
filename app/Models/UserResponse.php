<?php

namespace App\Models;

use App\Modules\UserResponses\Exception\NoUserResponsesForThisWeekException;
use App\Modules\UserResponses\Interfaces\UserResponseInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model implements UserResponseInterface
{
    use HasFactory;

    protected $table = 'user_response';

    protected $fillable = [
        'telegram_chat_id',
        'user_id',
        'text'
    ];

    /**
     * Для рассылки недельного отчета. Здесь рассылаются обратно пользователю те высказывания, которые он отправил приложению
     * @return Collection
     * @throws NoUserResponsesForThisWeekException
     */
    public function getUserResponsesForThisWeek(int $telegram_chat_id):Collection{
        $currentDate = now()->format('Y-m-d H:i');
        $weekStartDate = now()->startOfWeek()->format('Y-m-d H:i');

        $userResponses = UserResponse::whereBetween('created_at',[$weekStartDate, $currentDate])->where('telegram_chat_id', $telegram_chat_id)->get();

        if($userResponses->isEmpty()){
            throw new NoUserResponsesForThisWeekException();
        }

        return $userResponses;
    }

}
