<?php

namespace App\Services;

use App\Models\BestStatement;
use App\Models\Statement;
use App\Models\User;
use App\Models\UserResponse;
use http\Env\Request;

class BestStatementService
{
    /**
     * Функция для проучения лучших высказываний. Лучшие высказывания могут хранится в двух мечтах
     * @param int $userId
     * @return array
     * @throws \Exception
     */
    public function getBestStatements(int $userId){
        $userResponses = UserResponse::select('id', 'text')->where('user_id', $userId)->get()->toArray();
        $statements = Statement::select('id','text')->where('user_id', $userId)->where('is_best_statement', 1)->get()->toArray();

        $bestStatements[] = $userResponses;
        $bestStatements[] = $statements;

        if(empty($bestStatements)){
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
     * Функция для теста сохранения лучшего высказывания
     * @param string $chatId
     * @param string $text
     * @return BestStatement
     * @throws \Exception
     */
    public function saveBestStatement(string $chatId, string $text): BestStatement{
        $user = User::where('telegram_chat_id', $chatId)->first();

        if($user == null){
            throw new \Exception('there is no user with telegram_chat_id =' . $chatId);
        }

        $bestStatement = BestStatement::create(
            [
                "text" => $text,
                "user_id" => $user->id
            ]
        );

        return $bestStatement;
    }
}
