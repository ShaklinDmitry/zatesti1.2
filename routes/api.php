<?php

use App\Models\StatementSendingSchedule;
use App\Services\StatementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use NotificationChannels\Telegram\TelegramUpdates;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function (){
        Route::post('/statements', [\App\Modules\Statements\Infrastructure\Controllers\StatementController::class, 'createStatement']);
        Route::get('/statements', [\App\Modules\Statements\Infrastructure\Controllers\StatementController::class, 'getStatements']);
        Route::delete('/statements/{id}', [\App\Modules\Statements\Infrastructure\Controllers\StatementController::class, 'destroy']);
        Route::post('/statements/transfer-to-best-statements', [\App\Modules\Statements\Infrastructure\Controllers\StatementController::class, 'transferToBestStatements']);

        Route::get('/beststatements', [\App\Modules\BestStatements\Infrastructure\Controllers\BestStatementController::class, 'getBestStatements']);
        Route::delete('/beststatements/{id}', [\App\Modules\BestStatements\Infrastructure\Controllers\BestStatementController::class, 'destroy']);

        Route::post('/statements/text', [\App\Modules\Text\Infrastructure\Controllers\TextForStatementsController::class, 'createText']);
        Route::post('/text/generate-statements', [\App\Modules\Text\Infrastructure\Controllers\TextForStatementsController::class, 'makeStatementsFromText']);
    }
);

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::post('/statements-schedule',[\App\Http\Controllers\StatementScheduleController::class, 'setSendTime'])->middleware('auth:sanctum');

//Route::get('/check-schedule-every-minute',[\App\Http\Controllers\StatementScheduleController::class, 'executeEveryMinute']);
//Route::get('/check-schedule-every-sunday',[\App\Http\Controllers\StatementScheduleController::class, 'executeEverySunday']);

Route::get('/send-statement-at-time',[\App\Modules\StatementNotifications\Infrastructure\Controllers\StatementNotificationController::class, 'SendNotificationsToUsersAtTime']);

Route::post('/telegram-webhook',[\App\Http\Controllers\TelegramWebhookController::class, 'sendUserAnswer']);

Route::get('telegram', function () {
    $updates = TelegramUpdates::create()
        // (Optional). Get's the latest update. NOTE: All previous updates will be forgotten using this method.
         ->latest()

        // (Optional). Limit to 2 updates (By default, updates starting with the earliest unconfirmed update are returned).
    //    ->limit(2)

        // (Optional). Add more params to the request.
        ->options([
            'timeout' => 0,
        ])
        ->get();

    return $updates['result'];

});

Route::get('/testSendStatement', function (){

    $userNotifyCommand = app(\App\Modules\User\Application\UseCases\UserNotifyCommand::class);
    $userNotifyCommand->execute(3, 'test text', 2);

});
