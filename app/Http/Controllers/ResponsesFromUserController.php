<?php

namespace App\Http\Controllers;

use App\Services\UserResponseService;
use Illuminate\Http\Request;

class ResponsesFromUserController extends Controller
{

    /**
     * Для сохрарнения ответа пользователя
     * @param UserResponseService $userResponseService
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveResponse(UserResponseService $userResponseService){
        $saveUserResponseResult = $userResponseService->saveUserResponse();

        if($saveUserResponseResult){
            $responseData = [
                "data" => [
                    "message" => "User response was saved successfully.",
                ]
            ];
        }

        return response() -> json($responseData,200);

    }

}
