<?php

namespace App\Modules\BestStatements\Domain;

use App\Modules\BestStatements\Application\DTOs\BestStatementDTO;
use App\Modules\BestStatements\Application\DTOs\BestStatementDTOCollection;

interface BestStatementRepositoryInterface
{
    /**
     * Функуия для получения лучших высказываний.
     * @param int $userId
     * @return BestStatementDTOCollection
     */
    public function getBestStatements(int $userId): BestStatementDTOCollection;


    /**
     * Удалить лучшее высказывание по id
     * @param int $bestStatementId
     * @return bool
     */
    public function deleteBestStatement(int $bestStatementId): bool;


    /**
     * @param string $chatId
     * @param string $text
     * @return BestStatementDTO
     */
    public function addBestStatement(string $chatId, string $text): BestStatementDTO;
}
