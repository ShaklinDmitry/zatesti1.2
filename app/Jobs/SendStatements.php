<?php

namespace App\Jobs;

use App\Domains\Notifications\Interfaces\StatementNotification;
use App\Domains\Notifications\SendNotificationAboutNoStatementsForSendingCommand;
use App\Domains\Notifications\SendNotificationCommand;
use App\Domains\Statements\GetStatementForSendingCommand;
use App\Exceptions\NoStatementsForSendingException;
use App\Services\NotificationService;
use App\Services\StatementService;
use Illuminate\Bus\Queueable;
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
        try{
            foreach ($this->users as $user){
                $getStatementForSending = new GetStatementForSendingCommand($user->id);
                $statement = $getStatementForSending->execute();

                $sendNotificationCommand = new SendNotificationCommand($this->statementNotification);
                $sendNotificationCommand->execute($user->id, $statement);
            }
        }catch(NoStatementsForSendingException $exception){
            $exceptionOptions = $exception->getOptions();
            $sendNotificationAboutNoStatementsForSending = new SendNotificationAboutNoStatementsForSendingCommand();
            $sendNotificationAboutNoStatementsForSending->execute($exceptionOptions['userId']);
            Log::info($exception->getMessage());
        }
        catch(\Exception $exception){
            Log::info($exception->getMessage());
        }

    }
}
