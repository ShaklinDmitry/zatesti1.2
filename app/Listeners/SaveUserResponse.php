<?php

namespace App\Listeners;

use App\Events\SendUserResponse;
use App\Services\UserResponseService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserResponse
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
        $userResponseService = new UserResponseService();
        $userResponseService->saveUserResponse($event->chatId, $event->text);
    }
}
