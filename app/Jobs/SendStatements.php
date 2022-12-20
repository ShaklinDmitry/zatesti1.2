<?php

namespace App\Jobs;

use App\Services\StatementNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendStatements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $statementScheduleService = new StatementScheduleService();
            $users = $statementScheduleService->getUsersWhoAccordingToTheScheduleShouldSendMessage();

            $statementNotificationService = new StatementNotificationService();
            foreach ($users as $user){
                $statementNotificationService->sendNotification($user['id']);
            }

    }
}
