<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Domain\Statement;
use App\Modules\Statements\Domain\StatementRepositoryInterface;

class CreateStatementUseCase
{

    public function __construct(private int $userId, private string $text, private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * Создание высказывания
     * @return Statement
     */
    public function execute():Statement{
        $statementData = $this->statementRepository->createStatement($this->userId, $this->text);

        $statement = new Statement($statementData->id, $statementData->userId, $statementData->text);

        return $statement;
    }
}
