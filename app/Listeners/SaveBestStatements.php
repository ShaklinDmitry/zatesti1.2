<?php

namespace App\Listeners;

use App\Events\SendUserResponse;
use App\Services\BestStatementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveBestStatements
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
        $bestStatementService = new BestStatementService();
        $bestStatementService->saveBestStatement($event->chatId, $event->text);
    }
}
