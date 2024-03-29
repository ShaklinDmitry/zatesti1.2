<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Application\DTOs\StatementDTOCollection;
use App\Modules\Statements\Domain\StatementRepositoryInterface;

class GetStatementsUseCase
{

    public function __construct(private int $userId, private StatementRepositoryInterface $statementRepository)
    {
    }


    /**
     * Получить высказывания
     * @return StatementDTOCollection
     */
    public function execute():StatementDTOCollection{
        $statements = $this->statementRepository->getAllStatementsByUserId($this->userId);
        return $statements;
    }
}
