<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\StatementScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatementScheduleController extends Controller
{


    public function setSendTime(Request $request, StatementScheduleService $statementScheduleService){

        $saveExactTime = $statementScheduleService->saveExactTimeForSendingStatements($request->exactTimes, Auth::id());

        if($saveExactTime){
            $responseData = [
                "data" => [
                    "message" => "Time for sending statements was saved successful",
                ]
            ];
        }

        return response() -> json($responseData,200);
    }
}
