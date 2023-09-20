<?php

namespace App\Modules\BestStatements\Application\DTOs;

class BestStatementDTOCollection
{
    private array $collection;

    /**
     * Функция для добавления dto высказывания в коллекцию.
     * @param BestStatementDTO $dto
     * @return void
     */
    public function addDTOToCollection(BestStatementDTO $dto){
        $this->collection[] = $dto;
    }

    /**
     * Функция для получения коллекции.
     * @return array
     */
    public function getCollection(){
        return $this->collection;
    }
}
