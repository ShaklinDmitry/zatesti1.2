<?php

namespace App\Modules\Statements\Application\UseCases;

interface CreateStatementUseCaseInterface
{
    /**
     * @param int $userId
     * @param string $text
     * @return mixed
     */
    public function execute(int $userId, string $text);
}
