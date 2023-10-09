<?php

namespace App\Modules\StatementSendingSchedule\Application\DTOs;


class StatementSendingScheduleDTOCollection
{
    private array $collection;

    /**
     * Функция для добавления dto высказывания в коллекцию.
     * @param StatementSendingScheduleDTO $dto
     * @return void
     */
    public function addDTOToCollection(StatementSendingScheduleDTO $dto){
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
