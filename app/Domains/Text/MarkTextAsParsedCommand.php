<?php

namespace App\Domains\Text;

use App\Models\TextForStatements;

class MarkTextAsParsedCommand
{
    /**
     * Функция для того чтобы отметить что текст был распарсен
     * @param int $textId
     * @return int
     */
    public function execute(int $textId):int{
        $markTextResult = TextForStatements::where('id', $textId)->update(['is_parsed' => 1]);

        return $markTextResult;
    }
}
