<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use App\Services\NotificationService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class StatementNotificationController extends Controller
{
    /**
     * Отослать высказывание клиенту(отправляется то которое по списку идет)
     *
     * @return void
     */
//    public function sendStatementNotification(NotificationService $statementNotificationService){
//
//        $notificationSendResult = $statementNotificationService->sendNotification();
//
//        return $notificationSendResult;
//    }
}
