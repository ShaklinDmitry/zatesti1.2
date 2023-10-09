<?php

namespace App\Modules\WeeklyNotification;

use App\Modules\UserResponses\GetUserResponsesForThisWeekCommand;

class GetUserWeeklyNotifications
{
    public function __construct(){

    }

    /**
     * Функционал для получения уведомленний котороые будут расслыаться пользователям раз в неделю
     * @return array
     * @throws Exceptions\CreateWeeklyNotificationTextException
     * @throws \App\Modules\StatementSendingSchedule\Infrastructure\Exception\NoUsersForWeeklyNotificationsException
     * @throws \App\Modules\UserResponses\Exception\NoUserResponsesForThisWeekException
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
