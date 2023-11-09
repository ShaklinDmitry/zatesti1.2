<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Domain\StatementRepositoryInterface;

class SetStatementSendDateTimeCommand implements SetStatementSendDateTimeCommandInterface
{
    /**
     * @param StatementRepositoryInterface $statementRepository
     */
    public function __construct(private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * @param string $statementGuid
     * @return bool
     */
    public function execute(string $statementGuid):bool{
        return $this->statementRepository->setStatementSendDateTime($statementGuid);
    }
}
