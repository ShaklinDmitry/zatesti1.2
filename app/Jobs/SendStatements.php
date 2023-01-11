<?php

namespace App\Jobs;

use App\Models\StatementSendingSchedule;
use App\Services\NotificationService;
use App\Services\StatementScheduleService;
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

    private $userIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $usersIds)
    {
        $this->userIds = $usersIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationService = new NotificationService();
        foreach ($this->userIds as $userId){
            $notificationService->sendNotification($userId['user_id']);
        }
    }
}
