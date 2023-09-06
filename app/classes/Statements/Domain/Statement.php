<?php

namespace App\classes\Statements\Domain;

class Statement implements StatementInterface
{
    public function __construct(public int $id, public int $userId, public string $text)
    {
    }

    /**
     * Добавить новое высказывние
     * @param int $userId
     * @param string $text
     * @return mixed|void
     */
    public function addStatement(int $userId, string $text)
    {
        $this->statementRepository->addStatement($userId, $text);
    }
}
