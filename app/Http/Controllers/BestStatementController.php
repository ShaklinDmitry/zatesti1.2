<?php

namespace App\Http\Controllers;

use App\Classes\BestStatements\DeleteBestStatementCommand;
use App\Classes\BestStatements\Exceptions\NoBestStatementsToDeleteException;
use App\Classes\BestStatements\GetBestStatementsCommand;
use App\DTO\UserResponseDTO;
use App\Services\BestStatementService;
use App\Services\UserResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramUpdates;

class BestStatementController extends Controller
{

    /**
     * Функция для получения лучших высказываний
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBestStatements(){
        try{
            $getBestStatements = new GetBestStatementsCommand();
            $bestStatements = $getBestStatements->execute(Auth::id());

            $responseData = [
                "data" => [
                    "bestStatements" => $bestStatements
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
            $deleteBestStatement = new DeleteBestStatementCommand();
            $destroy = $deleteBestStatement->execute($request->id);

            if($destroy){
                return response() -> json(["data" => ["message" => "StatementEloquent was deleted successfull.",
                ]],200);
            }
        }catch (NoBestStatementsToDeleteException $exception){
            return response() -> json(["error" => ["message" => "StatementEloquent was not deleted.",
            ]],200);
        }
    }

}
