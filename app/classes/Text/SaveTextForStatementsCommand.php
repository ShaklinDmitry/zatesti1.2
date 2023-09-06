<?php

namespace App\classes\Text;

use App\Models\TextForStatementsEloquent;

class SaveTextForStatementsCommand
{
    /**
     * Функция для сохранения текста для высказываний
     * @param int $userId
     * @param string $text
     * @return TextForStatementsEloquent
     */
    public function execute(int $userId, string $text): TextForStatementsEloquent{
        $text = TextForStatementsEloquent::create([
            'text' => $text,
            'user_id' => $userId
        ]);

        return $text;
    }
}
