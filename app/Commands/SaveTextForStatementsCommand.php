<?php

namespace App\Commands;

use App\Models\TextForStatements;

class SaveTextForStatementsCommand
{
    /**
     * Функция для сохранения текста для высказываний
     * @param int $userId
     * @param string $text
     * @return TextForStatements
     */
    public function execute(int $userId, string $text): TextForStatements{
        $text = TextForStatements::create([
            'text' => $text,
            'user_id' => $userId
        ]);

        return $text;
    }
}
