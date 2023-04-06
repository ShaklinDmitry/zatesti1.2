<?php

namespace App\Http\Controllers;

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
            $bestStatementService = new BestStatementService();
            $bestStatements = $bestStatementService->getBestStatements(Auth::id());

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
        $bestStatementService = new BestStatementService();
        $destroy = $bestStatementService->deleteBestStatetement($request->id);

        if($destroy){
            return response() -> json(["data" => ["message" => "Statement was deleted successfull.",
            ]],200);
        }else{
            return response() -> json(["error" => ["message" => "Statement was not deleted.",
            ]],200);
        }
    }


    /**
     * Сделать лучшее высказывание обычным
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function makeBestStatementNormal(Request $request){
        $bestStatementService = new BestStatementService();
        $updateStatementToNormal = $bestStatementService->makeBestStatementNormal($request->id);

        if($updateStatementToNormal == true){
            return response() -> json(["data" => ["message" => "Statement now is normal."]], 200);
        }
    }


}
