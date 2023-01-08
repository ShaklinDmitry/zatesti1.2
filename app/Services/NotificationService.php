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
    public function sendNotification(int $userId){
        try{
            $statementService = new StatementService();
            $statement = $statementService->getStatementForSending($userId);

            $telegramNotification = new TelegramNotification($statement->text);
            $user = User::find($userId);
            $user->notify($telegramNotification);

            $statement->markStatementHasBeenSent($statement->id);

            return true;

        }catch(Exception $e) {

            return $e->getMessage();

        }
    }
}
