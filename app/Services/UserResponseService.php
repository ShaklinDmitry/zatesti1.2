<?php

namespace App\Services;

use App\classes\UserResponses\Models\UserResponse;
use App\DTO\UserResponseDTO;
use App\Models\User;

class UserResponseService
{

    public function __construct(){}

    /**
     * Функция для сохранения ответа пользователя
     * @param UserResponseRequest $request
     * @return UserResponse
     */
//    public function saveUserResponse(User $chatId, string $text){
//
//
//
//        if($user == null){
//            throw new \Exception('there is no user with telegram_chat_id =' . $chatId);
//        }
//
//
//        $userResponse = UserResponse::create(
//            [
//                "telegram_chat_id" => $chatId,
//                "text" => $text,
//                "user_id" => $user->id
//            ]
//        );
//
//        return $userResponse;
//    }

    /**
     * Получить ответы пользователей за эту неделю
     * @param User $user
     * @return mixed
     */
//    public function getUserResponsesForThisWeek(int $telegram_chat_id){
//        $currentDate = now()->format('Y-m-d H:i');
//        $weekStartDate = now()->startOfWeek()->format('Y-m-d H:i');
//
//        $userResponses = UserResponse::whereBetween('created_at',[$weekStartDate, $currentDate])->where('telegram_chat_id', $telegram_chat_id)->get();
//
//        return $userResponses;
//    }



}
