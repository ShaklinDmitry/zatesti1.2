<?php

namespace App\Jobs;

use App\Commands\SendNotificationCommand;
use App\Exceptions\NoStatementsForSendingException;
use App\Interfaces\StatementNotification;
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
    private $statementNotification;

    public function __construct($users, StatementNotification $statementNotification)
    {
        $this->users = $users;
        $this->statementNotification = $statementNotification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationService = new NotificationService();

        try{
            foreach ($this->users as $user){
                $statementService = new StatementService();
                $statement = $statementService->getStatementForSending($user->id);

                $sendNotificationCommand = new SendNotificationCommand($this->statementNotification);
                $sendNotificationCommand->execute($user->id, $statement);
            }
        }catch(NoStatementsForSendingException $exception){
            $exceptionOptions = $exception->getOptions();
            $notificationService->sendNotificationAboutNoStatementsForSending($exceptionOptions['userId']);
            Log::info($exception->getMessage());
        }
        catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }
}
