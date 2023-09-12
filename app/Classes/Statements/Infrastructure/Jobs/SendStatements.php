<?php

namespace App\Classes\Statements\Infrastructure\Jobs;

use App\Classes\Notifications\Interfaces\StatementNotificationSystem;
use App\Classes\Notifications\SendNotificationAboutNoStatementsForSendingCommand;
use App\Classes\Notifications\SendNotificationCommand;
use App\Classes\Statements\Application\UseCases\GetStatementForSendingUseCase;
use App\Classes\Statements\GetStatementForSendingCommand;
use App\Classes\Statements\Infrastructure\Repositories\StatementRepository;
use App\Exceptions\NoStatementsForSendingException;
use App\Services\NotificationService;
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

    public function __construct($users, StatementNotificationSystem $statementNotification)
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
                $statementRepository = new StatementRepository();

                $getStatementForSendingUseCase = new GetStatementForSendingUseCase(userId: $user->id, statementRepository: $statementRepository);
                $statement = $getStatementForSendingUseCase->execute();

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
