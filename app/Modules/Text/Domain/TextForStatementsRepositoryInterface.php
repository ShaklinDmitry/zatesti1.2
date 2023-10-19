<?php

namespace App\Modules\Text\Domain;

use App\Modules\Text\Application\DTO\TextForStatementDTO;

interface TextForStatementsRepositoryInterface
{
    public function getUnparsedTextForStatementsByUserId(int $userId): TextForStatementDTO;
    
    public function markTextParsed(int $textId);

    public function saveTextForStatements(string $guid, int $userId, string $text);
}
