<?php

namespace App\Http\Controllers;

use App\DTO\UserResponseDTO;
use App\Services\UserResponseService;
use Illuminate\Http\Request;
use NotificationChannels\Telegram\TelegramUpdates;

class ResponsesFromUserController extends Controller
{

    private UserResponseDTO $userResponseData;

    public function __construct(){
            $responseSource = TelegramUpdates::create()->latest()->options(['timeout' => 0,])->get();
            $responseText = $responseSource['result'][0]['message']['text'];
            $responseMessageId = $responseSource['result'][0]['message']['message_id'];
            $this->userResponseData = new UserResponseDTO($responseText, $responseMessageId);
    }

    /**
     * Для сохрарнения ответа пользователя
     * @param UserResponseService $userResponseService
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveResponse(UserResponseService $userResponseService){
        $saveUserResponseResult = $userResponseService->saveUserResponse($this->userResponseData);

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
