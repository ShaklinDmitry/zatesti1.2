<?php

namespace App\classes\Statements;

use App\Exceptions\NoStatementsForSendingException;
use App\Models\Statement;

class GetStatementForSendingCommand
{
    private int $userId;

    public function __construct(int $userId){
        $this->userId = $userId;
    }

    public function execute(){
        $statement = Statement::where('user_id', $this->userId)
            ->where('send_date_time', '1970-01-01 00:00:00')
            ->where('text','<>','')
            ->first();


        if($statement == null){
            throw new NoStatementsForSendingException('There are no statements to send to the user',0,
                null,['userId' => $this->userId]);
        }

        return $statement;
    }
}
