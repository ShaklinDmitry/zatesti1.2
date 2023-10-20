<?php

namespace App\Modules\Text\Application\UseCases;

interface SaveTextForStatementsCommandInterface
{
    public function execute(int $userId, string $text);
}
