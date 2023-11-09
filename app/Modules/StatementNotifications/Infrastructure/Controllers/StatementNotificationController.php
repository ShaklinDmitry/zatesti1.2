<?php

namespace App\Modules\StatementNotifications\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\StatementNotifications\Application\UseCases\SendNotificationsToUsersAtTimeCommandInterface;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class StatementNotificationController extends Controller
{

    /**
     * @param Request $request
     * @param SendNotificationsToUsersAtTimeCommandInterface $sendNotificationsToUsersAtTimeCommand
     * @return void
     */
    public function SendNotificationsToUsersAtTime(Request $request, SendNotificationsToUsersAtTimeCommandInterface $sendNotificationsToUsersAtTimeCommand){
        try{
        //    Log::debug("SendNotificationsToUsersAtTime", ['request' => $request]);
            $sendNotificationsToUsersAtTimeCommand->execute(date("H:i"));
        }catch (\Exception $exception){

        }

    }
}
