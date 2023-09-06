<?php

namespace App\classes\Text\Domain;

use App\classes\Text\Infrastructure\DTO\TextForStatementData;

interface TextForStatementsRepositoryInterface
{
    public function getUnparsedTextForStatementsByUserId(int $userId): TextForStatementData;

    public function getTextForStatementsByTextId(int $textId): TextForStatementData;

    public function markTextParsed(int $textId);
}
