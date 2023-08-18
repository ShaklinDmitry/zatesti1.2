<?php

namespace App\classes\Text\Domain;

interface TextForStatementsRepositoryInterface
{
    public function getUnparsedTextForStatementsByUserId(int $userId);
}
