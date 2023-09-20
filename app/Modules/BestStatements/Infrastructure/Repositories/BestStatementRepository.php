<?php

namespace App\Modules\BestStatements\Infrastructure\Repositories;

use App\Models\BestStatementEloquent;
use App\Models\User;
use App\Modules\BestStatements\Application\DTOs\BestStatementDTO;
use App\Modules\BestStatements\Application\DTOs\BestStatementDTOCollection;
use App\Modules\BestStatements\Domain\BestStatementRepositoryInterface;
use App\Modules\BestStatements\Infrastructure\Exceptions\NoBestStatementsForUserException;
use App\Modules\BestStatements\Infrastructure\Exceptions\NoBestStatementsToDeleteException;

class BestStatementRepository implements BestStatementRepositoryInterface
{
    /**
     * @param int $userId
     * @return BestStatementDTOCollection
     * @throws NoBestStatementsForUserException
     */
    public function getBestStatements(int $userId): BestStatementDTOCollection
    {
        $bestStatements = BestStatementEloquent::select('id', 'text')->where('user_id', $userId)->get();

        if($bestStatements->isEmpty()){
            throw new NoBestStatementsForUserException();
        }

        $bestStatementDTOCollection = new BestStatementDTOCollection();

        foreach ($bestStatements as $bestStatement){
            $bestStatementDTO = new BestStatementDTO(id: $bestStatement->id, text: $bestStatement->text, userId: $userId);
            $bestStatementDTOCollection->addDTOToCollection($bestStatementDTO);
        }

        return $bestStatementDTOCollection;
    }

    /**
     * @param int $bestStatementId
     * @return bool
     * @throws NoBestStatementsToDeleteException
     */
    public function deleteBestStatement(int $bestStatementId): bool
    {
        $bestStatement = BestStatementEloquent::where('id', $bestStatementId)->first();

        if($bestStatement == null){
            throw new NoBestStatementsToDeleteException();
        }

        return $bestStatement->delete();
    }

    /**
     * Добавить лучшее высказывание
     * @param string $chatId
     * @param string $text
     * @return BestStatementDTO
     * @throws \Exception
     */
    public function addBestStatement(string $chatId, string $text): BestStatementDTO
    {
        $user = User::where('telegram_chat_id', $chatId)->first();

        if($user == null){
            throw new \Exception('there is no user with telegram_chat_id =' . $chatId);
        }

        $bestStatement = BestStatementEloquent::create(
            [
                "text" => $text,
                "user_id" => $user->id
            ]
        );

        $bestStatementDTO = new BestStatementDTO(id: $bestStatement->id, text: $bestStatement->text, userId: $bestStatement->userId);

        return $bestStatementDTO;
    }
}
