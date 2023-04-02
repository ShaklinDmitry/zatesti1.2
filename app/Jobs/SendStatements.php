<?php

namespace App\Jobs;

use App\Models\StatementSendingSchedule;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\StatementScheduleService;
use App\Services\StatementService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendStatements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $notificationService = new NotificationService();
            foreach ($this->users as $user){
                $statementService = new StatementService();
                $statement = $statementService->getStatementForSending($user->id);

                $notificationService->sendNotification($user->id, $statement);
            }
        }catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }
}
