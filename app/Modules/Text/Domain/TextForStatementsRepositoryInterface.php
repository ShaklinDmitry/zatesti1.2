<?php

namespace App\Modules\Text\Domain;

use App\Modules\Text\Infrastructure\DTO\TextForStatementData;

interface TextForStatementsRepositoryInterface
{
    public function getUnparsedTextForStatementsByUserId(int $userId): TextForStatementData;

    public function getTextForStatementsByTextId(int $textId): TextForStatementData;

    public function markTextParsed(int $textId);

    public function saveTextForStatements(int $userId, string $text): TextForStatementData;
}
