<?php

namespace App\Modules\Statements\Domain;

class Statement implements StatementInterface
{

    private \DateTime $sendDateTime;


    /**
     * @param int $id
     * @param int $userId
     * @param string $text
     */
    public function __construct(public int $id, public int $userId, public string $text)
    {
    }

    /**
     * Функция для установки даты и времени отправки высказывания
     * @param \DateTime $sendDateTime
     * @return void
     */
    public function setSendDateTime(\DateTime $sendDateTime):void{
        $this->sendDateTime = $sendDateTime;
    }

}
