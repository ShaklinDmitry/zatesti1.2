<?php

namespace App\Modules\Statements\Application\UseCases;

interface SetStatementSendDateTimeCommandInterface
{
    /**
     * @param string $statementGuid
     * @return mixed
     */
    public function execute(string $statementGuid);
}
