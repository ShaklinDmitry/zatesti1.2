<?php

namespace App\Classes\Statements\Application\UseCases;

use App\Classes\Statements\Domain\StatementRepositoryInterface;
use App\Classes\Statements\Infrastructure\DTO\StatementDataCollection;

class GetStatementsUseCase
{

    public function __construct(private int $userId, private StatementRepositoryInterface $statementRepository)
    {
    }


    /**
     * Получить высказывания
     * @return StatementDataCollection
     */
    public function execute():StatementDataCollection{
        $statements = $this->statementRepository->getAllStatementsByUserId($this->userId);
        return $statements;
    }
}
