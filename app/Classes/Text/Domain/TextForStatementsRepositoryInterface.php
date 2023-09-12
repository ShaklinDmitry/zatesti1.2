<?php

namespace App\Classes\Text\Domain;

use App\Classes\Text\Infrastructure\DTO\TextForStatementData;

interface TextForStatementsRepositoryInterface
{
    public function getUnparsedTextForStatementsByUserId(int $userId): TextForStatementData;

    public function getTextForStatementsByTextId(int $textId): TextForStatementData;

    public function markTextParsed(int $textId);

    public function saveTextForStatements(int $userId, string $text): TextForStatementData;
}
