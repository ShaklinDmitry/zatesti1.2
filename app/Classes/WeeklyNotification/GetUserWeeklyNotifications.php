<?php

namespace App\Classes\WeeklyNotification;

use App\Classes\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedThisWeekCommand;
use App\Classes\UserResponses\GetUserResponsesForThisWeekCommand;
use App\Models\StatementSendingSchedule;
use App\Models\UserResponse;

class GetUserWeeklyNotifications
{
    public function __construct(){

    }

    /**
     * Функционал для получения уведомленний котороые будут расслыаться пользователям раз в неделю
     * @return array
     * @throws Exceptions\CreateWeeklyNotificationTextException
     * @throws \App\Classes\StatementSendingSchedule\Exception\NoUsersForWeeklyNotificationsException
     * @throws \App\Classes\UserResponses\Exception\NoUserResponsesForThisWeekException
     */
//    public function execute(){
//
//        $userWeeklyNotifications = [];
//
//        $statementSendingSchedule = new StatementSendingSchedule();
//        $usersWhoShouldBeNotifiedThisWeek = $statementSendingSchedule->getUsersWhoShouldBeNotifiedThisWeek();
//
//        foreach ($usersWhoShouldBeNotifiedThisWeek as $user){
//            $userResponse = new UserResponse();
//            $userResponses = $userResponse->getUserResponsesForThisWeek($user->telegram_chat_id);
//
//            if($userResponses->isEmpty())
//                continue;
//
//            $weeklyNotificationText = new WeeklyNotificationText();
//            $text = $weeklyNotificationText->createText();
//
//            $userWeeklyNotifications[] = new WeeklyNotification(user: $user, text: $text);
//        }
//
//        return $userWeeklyNotifications;
//    }
}
