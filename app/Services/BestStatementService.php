<?php

namespace App\Services;

use App\Models\Statement;
use App\Models\User;
use App\Models\UserResponse;
use http\Env\Request;

class BestStatementService
{
    /**
     * Функция для проучения лучших высказываний отправленных пользователем
     * @param User $user
     * @return UserResponse
     * @throws \Exception
     */
    public function getBestStatements(int $userId){
        $bestStatements = UserResponse::select('id', 'text')->where('user_id', $userId)->get();

        if($bestStatements->isEmpty()){
            throw new \Exception('there no best responses for this user');
        }

        return $bestStatements;
    }

    /**
     * Функция для удаления лучших высказываний
     * @param Request $request
     * @return mixed
     */
    public function deleteBestStatetement(int $id):bool {
        return UserResponse::where('id', $id)->delete();
    }


    /**
     * Сделать лучшее высказывание обычным
     * @param int $statementId
     * @return bool
     */
    public function makeBestStatementNormal(int $statementId):bool{
        return Statement::where('id', $statementId)->update(['is_best_statement' => 0]);
    }
}
