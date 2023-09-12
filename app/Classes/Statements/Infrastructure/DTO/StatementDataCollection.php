<?php

namespace App\Classes\Statements\Infrastructure\DTO;

class StatementDataCollection
{
    private array $collection;


    /**
     * Функция для добавления dto высказывания в коллекцию
     * @param StatementData $statementData
     * @return array
     */
    public function addStatementData(StatementData $statementData):array{
        $this->collection[] = $statementData;
        return $this->collection;
    }
}
