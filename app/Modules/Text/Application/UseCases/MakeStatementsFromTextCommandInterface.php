<?php

namespace App\Modules\Text\Application\UseCases;

interface MakeStatementsFromTextCommandInterface
{
    public function execute(int $userId);
}
