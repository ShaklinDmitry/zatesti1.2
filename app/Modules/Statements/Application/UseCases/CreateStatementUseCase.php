<?php

namespace App\Modules\Statements\Application\UseCases;

use App\Modules\Statements\Application\DTOs\StatementDTO;
use App\Modules\Statements\Domain\Statement;
use App\Modules\Statements\Domain\StatementRepositoryInterface;

class CreateStatementUseCase implements CreateStatementUseCaseInterface
{

    public function __construct(private StatementRepositoryInterface $statementRepository)
    {
    }

    /**
     * Создание высказывания
     * @param int $userId
     * @param string $text
     * @return StatementDTO
     */
    public function execute(int $userId, string $text):StatementDTO{

        $statement = new Statement($userId, $text);

        $statementDTO = $this->statementRepository->createStatement($statement->userId, $statement->text);

        return $statementDTO;
    }
}
