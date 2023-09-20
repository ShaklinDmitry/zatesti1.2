<?php

namespace App\Modules\BestStatements\Application;

use App\Modules\BestStatements\Application\DTOs\BestStatementDTOCollection;
use App\Modules\BestStatements\Domain\BestStatementRepositoryInterface;

class GetBestStatementsUseCase
{

    /**
     * @param int $userId
     * @param BestStatementRepositoryInterface $bestStatementRepository
     */
    public function __construct(private int $userId, private BestStatementRepositoryInterface $bestStatementRepository)
    {
    }

    /**
     * @return BestStatementDTOCollection
     */
    public function execute():BestStatementDTOCollection{
        return $this->bestStatementRepository->getBestStatements($this->userId);
    }
}
