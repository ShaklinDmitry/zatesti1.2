<?php

namespace App\classes\Statements\Application\UseCases;

use App\classes\Statements\Domain\Statement;
use App\classes\Statements\Domain\StatementRepositoryInterface;

class CreateStatementUseCase
{

    public function __construct(public StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * Создание высказывания
     * @return Statement
     */
    public function execute(int $userId, string $text):Statement{
        $statementData = $this->statementRepository->createStatement($userId, $text);

        $statement = new Statement($statementData->id, $statementData->userId, $statementData->text);

        return $statement;
    }
}
