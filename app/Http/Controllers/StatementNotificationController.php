<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use App\Services\StatementNotificationService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class StatementNotificationController extends Controller
{
    /**
     * Отослать высказывание клиенту(отправляется то которое по списку идет)
     *
     * @return void
     */
    public function sendStatementNotification(){
        $statementNotificationService = new StatementNotificationService();
        $statementNotificationService->sendStatementNotification();
    }
}
