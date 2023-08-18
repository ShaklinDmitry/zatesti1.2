<?php

namespace App\classes\Text;

use App\Models\TextForStatementsModel;

class SaveTextForStatementsCommand
{
    /**
     * Функция для сохранения текста для высказываний
     * @param int $userId
     * @param string $text
     * @return TextForStatementsModel
     */
    public function execute(int $userId, string $text): TextForStatementsModel{
        $text = TextForStatementsModel::create([
            'text' => $text,
            'user_id' => $userId
        ]);

        return $text;
    }
}
