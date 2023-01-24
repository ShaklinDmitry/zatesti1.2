<?php

namespace App\Services;

use App\Models\Statement;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class NotificationService
{

    /**
     * Для отправки уведомлений с высказываниями
     * @param int $userId
     * @return bool|string
     * @throws \Exception
     */
    public function sendNotification(int $userId, Statement $statement){
        try{
            $telegramNotification = new TelegramNotification($statement->text);

            $user = User::find($userId);
            $user->last_statement_id_sent = $statement->id;
            $user->save();

            $user->notify($telegramNotification);

        }catch(Exception $e) {

            return $e->getMessage();

        }
    }
}
