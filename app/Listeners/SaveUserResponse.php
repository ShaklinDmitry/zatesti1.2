<?php

namespace App\Listeners;

use App\classes\UserResponses\Models\UserResponse;
use App\Events\SendUserResponse;
use App\Models\User;
use App\Services\UserResponseService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class  SaveUserResponse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendUserResponse  $event
     * @return void
     */
    public function handle(SendUserResponse $event)
    {
        $user = User::where('telegram_chat_id', $event->chatId)->first();

        UserResponse::create(
            [
                "telegram_chat_id" => $event->chatId,
                "text" => $event->text,
                "user_id" => $user->id
            ]
        );
    }
}
