<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Application\DTOs\StatementDTO;

interface GetStatementForSendingCommandInterface
{
    /**
     * @param int $userId
     * @return mixed
     */
    public function execute(int $userId):StatementDTO;
}
