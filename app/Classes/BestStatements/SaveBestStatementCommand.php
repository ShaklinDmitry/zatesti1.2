<?php

namespace App\Classes\BestStatements;

use App\Models\BestStatement;
use App\Models\User;

class SaveBestStatementCommand
{
    /**
     * Функция для теста сохранения лучшего высказывания
     * @param string $chatId
     * @param string $text
     * @return BestStatement
     * @throws \Exception
     */
    public function execute(string $chatId, string $text): BestStatement{
        $user = User::where('telegram_chat_id', $chatId)->first();

        if($user == null){
            throw new \Exception('there is no user with telegram_chat_id =' . $chatId);
        }

        $bestStatement = BestStatement::create(
            [
                "text" => $text,
                "user_id" => $user->id
            ]
        );

        return $bestStatement;
    }
}
