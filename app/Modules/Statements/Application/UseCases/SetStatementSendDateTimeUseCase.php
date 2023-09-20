<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Domain\StatementRepositoryInterface;

class SetStatementSendDateTimeUseCase
{

    public function __construct(private int $statementId, private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * Для установки времени отправки высказывания.
     * @return bool
     */
    public function execute():bool{
        return $this->statementRepository->setStatementSendDateTime($this->statementId);
    }
}
