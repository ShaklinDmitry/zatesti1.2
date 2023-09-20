<?php

namespace App\Modules\Statements\Domain;

use App\Models\StatementEloquent;

interface StatementInterface
{
    public function setSendDateTime(\DateTime $sendDateTime):void;
}
