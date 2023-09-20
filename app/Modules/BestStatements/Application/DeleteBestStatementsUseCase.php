<?php

namespace App\Modules\BestStatements\Application;

use App\Modules\BestStatements\Domain\BestStatementRepositoryInterface;

class DeleteBestStatementsUseCase
{

    /**
     * @param int $bestStatementId
     * @param BestStatementRepositoryInterface $bestStatementRepository
     */
    public function __construct(private int $bestStatementId, private BestStatementRepositoryInterface $bestStatementRepository)
    {
    }


    /**
     * @return bool
     */
    public function execute():bool{
        return $this->bestStatementRepository->deleteBestStatement($this->bestStatementId);
    }
}
