<?php

namespace App\Classes\Statements\Application\UseCases;

use App\Classes\Statements\Domain\StatementRepositoryInterface;
use App\Classes\Statements\Infrastructure\DTO\StatementData;

class GetStatementForSendingUseCase
{

    public function __construct(private int $userId, private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * @return StatementData
     */
    public function execute():StatementData{
        $statementForSending = $this->statementRepository->getStatementForSendingByUserId($this->userId);

        return $statementForSending;
    }
}
