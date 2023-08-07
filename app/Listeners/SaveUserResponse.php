<?php

namespace App\Listeners;

use App\Events\SendUserResponse;
use App\Models\User;
use App\Models\UserResponse;
use App\Services\UserResponseService;

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
