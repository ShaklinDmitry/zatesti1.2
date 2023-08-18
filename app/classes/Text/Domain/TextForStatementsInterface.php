<?php

namespace App\classes\Text\Domain;

interface TextForStatementsInterface
{
    public function makeStatementsFromText(int $userId);
}
