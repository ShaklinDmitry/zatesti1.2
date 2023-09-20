<?php

namespace App\Modules\BestStatements\Infrastructure\Controllers;

use App\DTO\UserResponseDTO;
use App\Http\Controllers\Controller;
use App\Modules\BestStatements\Application\DeleteBestStatementsUseCase;
use App\Modules\BestStatements\Application\GetBestStatementsUseCase;
use App\Modules\BestStatements\DeleteBestStatementCommand;
use App\Modules\BestStatements\Infrastructure\Exceptions\NoBestStatementsToDeleteException;
use App\Modules\BestStatements\Infrastructure\Repositories\BestStatementRepository;
use App\Services\BestStatementService;
use App\Services\UserResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BestStatementController extends Controller
{

    /**
     * Функция для получения лучших высказываний
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBestStatements(){
        try{
            $bestStatementRepository = new BestStatementRepository();

            $getBestStatementsUseCase = new GetBestStatementsUseCase(userId: Auth::id(), bestStatementRepository: $bestStatementRepository);
            $bestStatements = $getBestStatementsUseCase->execute();

            $responseData = [
                "data" => [
                    "bestStatements" => $bestStatements->getCollection()
                ]
            ];

            return response()->json($responseData, 200);

        }catch (\Exception $exception){
            Log::info($exception->getMessage());

            return response()->json(
                ["error" => [
                    "message" => $exception->getMessage()
                ]], 200);
        }
    }


    /**
     * Удаление лучшего высказывания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(Request $request){
        try{
            $bestStatementRepository = new BestStatementRepository();

            $deleteBestStatementsUseCase = new DeleteBestStatementsUseCase(bestStatementId: $request->id, bestStatementRepository: $bestStatementRepository);
            $destroy = $deleteBestStatementsUseCase->execute();

            if($destroy){
                return response() -> json(["data" => ["message" => "statement was deleted successfull.",
                ]],200);
            }
        }catch (NoBestStatementsToDeleteException $exception){
            return response() -> json(["error" => ["message" => "statement was not deleted.",
            ]],200);
        }
    }

}
