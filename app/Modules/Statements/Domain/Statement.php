<?php

namespace App\Modules\Statements\Domain;

class Statement implements StatementInterface
{

    private \DateTime $sendDateTime;
    public string $guid;

    /**
     * @param int $id
     * @param int $userId
     * @param string $text
     */
    public function __construct(public int $userId, public string $text)
    {
        $this->guid = uniqid();
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
