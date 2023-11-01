<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Application\DTOs\StatementDTO;
use App\Modules\Statements\Domain\StatementRepositoryInterface;

class GetStatementForSendingCommand implements GetStatementForSendingCommandInterface
{

    /**
     * @param StatementRepositoryInterface $statementRepository
     */
    public function __construct(private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * @param int $userId
     * @return StatementDTO
     */
    public function execute(int $userId):StatementDTO{
        $statementForSending = $this->statementRepository->getStatementForSendingByUserId($userId);

        return $statementForSending;
    }
}
