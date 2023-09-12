<?php

namespace App\Classes\Text\Domain;

use App\Classes\Text\Application\Events\TextForStatementsIsParsed;
use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatementsEloquent;

class TextForStatements implements TextForStatementsInterface
{

    private bool $isParsed;

    public function __construct(public int $id, public int $userId, public string $text)
    {

    }

    /**
     * @param int $textId
     * @return string[]
     */
    public function parseTextIntoStatements(): array
    {
        $statements = explode(".", $this->text);
        return $statements;
    }


    /**
     * Функция для того чтобы отметить что текст был распарсен
     * @return $this
     */
    public function markTextAsParsed(): TextForStatements{
        $this->isParsed = 1;
        return $this;
    }
}
