<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Отослать высказывание клиенту
     *
     * @return void
     */
    public function sendNotification(){
        $user = \App\Models\User::find(1);
        Auth::login($user);
        $user = auth()->user();

//        $statement = DB::select(
//            "select * from statement where send_date_time = '1970-01-01 00:00:00' limit 1"
//        );

        $statementModel = new Statement();
        $statement = $statementModel->getNotSendedStatement();
      //  dd($statement->getNotSendedStatement());

        $user->notify(new \App\Notifications\TelegramNotification($statement->text));

        $statement->markSendedStatement($statement->id);

//        DB::update(
//            'update statement set `send_date_time` = NOW() where id = ?',
//            [$statement[0]->id]
//        );
    }
}
