<?php

namespace App\classes\Text;

use App\Models\TextForStatementsModel;

class MarkTextAsParsedCommand
{
    /**
     * Функция для того чтобы отметить что текст был распарсен
     * @param int $textId
     * @return int
     */
    public function execute(int $textId):int{
        $markTextResult = TextForStatementsModel::where('id', $textId)->update(['is_parsed' => 1]);

        return $markTextResult;
    }
}
