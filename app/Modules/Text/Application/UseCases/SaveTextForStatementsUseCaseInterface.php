<?php

namespace App\Modules\Text\Application\UseCases;

interface SaveTextForStatementsUseCaseInterface
{
    public function execute(int $userId, string $text);
}
