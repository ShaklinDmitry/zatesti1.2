<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Domain\StatementRepositoryInterface;
use App\Modules\Statements\Infrastructure\DTOs\StatementDTO;

class GetStatementForSendingUseCase
{

    public function __construct(private int $userId, private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * @return StatementDTO
     */
    public function execute():StatementDTO{
        $statementForSending = $this->statementRepository->getStatementForSendingByUserId($this->userId);

        return $statementForSending;
    }
}
