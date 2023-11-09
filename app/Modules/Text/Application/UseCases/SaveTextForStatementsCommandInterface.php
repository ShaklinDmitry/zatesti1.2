<?php

namespace App\Modules\Text\Application\UseCases;

interface SaveTextForStatementsCommandInterface
{
    /**
     * @param int $userId
     * @param string $text
     * @return mixed
     */
    public function execute(int $userId, string $text);
}
