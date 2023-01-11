<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
//header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization, Accept, X-Requested-With');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use NotificationChannels\Telegram\TelegramUpdates;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Support\Facades\Auth;
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

Route::post('/statements', [\App\Http\Controllers\StatementController::class, 'createStatement'])->middleware('auth:sanctum');
Route::get('/statements', [\App\Http\Controllers\StatementController::class, 'getStatements'])->middleware('auth:sanctum');
Route::delete('/statements',[\App\Http\Controllers\StatementController::class, 'deleteStatement']);
//Route::post('/statements/text', [\App\Http\Controllers\TextForStatementsController::class, 'createText'])->middleware('cors');
Route::post('/statements/text', [\App\Http\Controllers\TextForStatementsController::class, 'createText'])->middleware('auth:sanctum');
Route::post('/text/generate-statements', [\App\Http\Controllers\TextForStatementsController::class, 'makeStatementsFromText'])->middleware('auth:sanctum');


Route::get('/saveUserResponse', [\App\Http\Controllers\ResponsesFromUserController::class, 'saveResponse']);

//Route::get('/notification', [\App\Http\Controllers\StatementNotificationController::class, 'sendStatementNotification']);

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::post('/statements-schedule',[\App\Http\Controllers\StatementScheduleController::class, 'setSendTime'])->middleware('auth:sanctum');

Route::get('/check-schedule-every-minute',[\App\Http\Controllers\StatementScheduleController::class, 'executeEveryMinute']);


Route::post('/telegram-webhook',[\App\Http\Controllers\TelegramWebhookController::class, 'sendAnswer']);

Route::post('/startRMQ',[\App\Http\Controllers\TestControllerForRabbitMQ::class, 'createTask']);
Route::post('/getRMQ',[\App\Http\Controllers\TestControllerForRabbitMQ::class, 'receiveTask']);

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

//    if($updates['ok']) {
//        // Chat ID
//        $chatId = $updates['result'][0]['message']['chat']['id'];
//
//       // dd($chatId);
//
//        return TelegramMessage::create()
//            // Optional recipient user id.
//            ->to($chatId)
//            // Markdown supported.
//            ->content("Hello there!");
//
//        //     return $chatId;
//    }
});
