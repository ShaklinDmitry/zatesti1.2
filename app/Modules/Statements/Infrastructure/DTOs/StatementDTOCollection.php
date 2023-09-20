<?php

namespace App\Modules\Statements\Infrastructure\DTOs;

class StatementDTOCollection
{
    private array $collection;

    /**
     * Функция для добавления dto высказывания в коллекцию.
     * @param StatementDTO $statementData
     * @return void
     */
    public function addStatementData(StatementDTO $statementData){
        $this->collection[] = $statementData;
    }

    /**
     * Функция для получения коллекции.
     * @return array
     */
    public function getCollection(){
        return $this->collection;
    }
}
