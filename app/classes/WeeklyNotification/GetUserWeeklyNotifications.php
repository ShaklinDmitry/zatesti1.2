<?php

namespace App\classes\WeeklyNotification;

use App\classes\StatementSendingSchedule\GetUsersWhoShouldBeNotifiedThisWeekCommand;
use App\classes\UserResponses\GetUserResponsesForThisWeekCommand;

class GetUserWeeklyNotifications
{
    public function __construct(){

    }

    /**
     * Функционал для получения уведомленний котороые будут расслыаться пользователям раз в неделю
     * @return array
     * @throws Exceptions\CreateWeeklyNotificationTextException
     * @throws \App\classes\StatementSendingSchedule\Exception\NoUsersForWeeklyNotificationsException
     * @throws \App\classes\UserResponses\Exception\NoUserResponsesForThisWeekException
     */
    public function execute(){

        $userWeeklyNotifications = [];

        $getUsersWhoShouldBeNotifiedThisWeek = new GetUsersWhoShouldBeNotifiedThisWeekCommand();
        $usersWhoShouldBeNotifiedThisWeek = $getUsersWhoShouldBeNotifiedThisWeek->execute();

        foreach ($usersWhoShouldBeNotifiedThisWeek as $user){
            $getUserResponsesForThisWeek = new GetUserResponsesForThisWeekCommand();
            $userResponses = $getUserResponsesForThisWeek->execute($user->telegram_chat_id);

            if($userResponses->isEmpty())
                continue;

            $createWeeklyNotificationText = new CreateWeeklyNotificationTextCommand($userResponses);
            $weeklyNotificationText = $createWeeklyNotificationText->execute();

            $userWeeklyNotifications[] = new UserWeeklyNotification(user:$user, text:$weeklyNotificationText);
        }

        return $userWeeklyNotifications;
    }
}
