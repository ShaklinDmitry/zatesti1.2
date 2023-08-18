<?php

namespace App\Models;

use App\classes\StatementSendingSchedule\Exception\NoUsersForWeeklyNotificationsException;
use App\classes\StatementSendingSchedule\Interfaces\StatementSendingScheduleInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatementSendingSchedule extends Model implements StatementSendingScheduleInterface
{
    use HasFactory;

    protected $table = 'send_statements_schedule';

    protected $fillable = [
        'user_id',
        'exact_time'
    ];

    /**
     * Функция для сохранения конкретного времени, по которому будет осуществляться отправка высказываний
     * @param string $times
     * @param int $userId
     * @return void
     */
    public function fillWithTimeForSending(string $times, int $userId){
        $times = explode(";", $times);

        foreach ($times as $time){
            StatementSendingSchedule::create([
                'user_id' => $userId,
                'exact_time' => $time
            ]);
        }
    }

    /**
     * Функция для того чтобы получить список пользователей, которым будет проводиться результирующая рассылка на этой неделе
     * @return array
     * @throws NoUsersForWeeklyNotificationsException
     */
    public function getUsersWhoShouldBeNotifiedThisWeek()
    {
        $listOfUsersInSchedule = StatementSendingSchedule::distinct()->get(['user_id']);

        if($listOfUsersInSchedule->isEmpty()){
            throw new NoUsersForWeeklyNotificationsException();
        }

        $users = [];
        foreach ($listOfUsersInSchedule as $userRow){
            $users[] = User::find($userRow->user_id);
        }

        return $users;
    }
}
