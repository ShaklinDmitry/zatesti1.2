<?php

namespace App\Http\Controllers;

use App\DTO\UserResponseDTO;
use App\Services\UserResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramUpdates;

class ResponsesFromUserController extends Controller
{

    /**
     * Функция для получения лучших высказываний
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBestStatements(){
        try{
            $userResponseService = new UserResponseService();
            $bestStatements = $userResponseService->getBestStatements(Auth::id());

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
        $userResponseService = new UserResponseService();
        $destroy = $userResponseService->deleteBestStatetement($request->id);

        if($destroy){
            return response() -> json(["data" => ["message" => "Statement was deleted successfull.",
            ]],200);
        }else{
            return response() -> json(["error" => ["message" => "Statement was not deleted.",
            ]],200);
        }
    }


}
