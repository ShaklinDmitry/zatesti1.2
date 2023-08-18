<?php

namespace App\classes\WeeklyNotification;

use App\classes\StatementSendingSchedule\Interfaces\StatementSendingScheduleInterface;
use App\classes\UserResponses\Interfaces\UserResponseInterface;
use App\classes\WeeklyNotification\Exceptions\CreateWeeklyNotificationTextException;
use App\Models\StatementSendingSchedule;
use App\Models\UserResponse;
use Illuminate\Support\Collection;

class WeeklyNotification implements WeeklyNotificationInterface
{
    public function __construct(public StatementSendingScheduleInterface $statementSendingSchedule, public UserResponseInterface $userResponse, public WeeklyNotificationTextInterface $weeklyNotificationText)
    {
    }

    /**
     * Функционал для получения уведомленний котороые будут расслыаться пользователям раз в неделю
     * @return array
     * @throws CreateWeeklyNotificationTextException
     * @throws \App\classes\StatementSendingSchedule\Exception\NoUsersForWeeklyNotificationsException
     * @throws \App\classes\UserResponses\Exception\NoUserResponsesForThisWeekException
     */
    public function getUserWeeklyNotifications(): array{

        $userWeeklyNotifications = [];

        $usersWhoShouldBeNotifiedThisWeek = $this->statementSendingSchedule->getUsersWhoShouldBeNotifiedThisWeek();

        foreach ($usersWhoShouldBeNotifiedThisWeek as $user){
            $userResponses = $this->userResponse->getUserResponsesForThisWeek($user->telegram_chat_id);

            if($userResponses->isEmpty())
                continue;

            $text = $this->weeklyNotificationText->createText($userResponses);

            $userWeeklyNotifications[] = new UserWeeklyNotificationDTO(user: $user, text: $text);
        }

        return $userWeeklyNotifications;
    }
}
