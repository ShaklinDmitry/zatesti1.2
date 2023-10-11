<?php

namespace App\Modules\Text\Application;

use App\Modules\Text\Domain\TextForStatementsRepositoryInterface;

interface TextForStatementsServiceInterface
{
    public function saveText(int $userId, string $text, TextForStatementsRepositoryInterface $textForStatementsRepository);

    public function makeStatementsFromText(int $userId, TextForStatementsRepositoryInterface $textForStatementsRepository);
}
