<?php

namespace App\Modules\Statements\Infrastructure\Jobs;

use App\Exceptions\NoStatementsForSendingException;
use App\Modules\Notifications\Application\SendNotificationUseCase;
use App\Modules\Notifications\Domain\StatementNotificationSystemInterface;
use App\Modules\Notifications\SendNotificationAboutNoStatementsForSendingCommand;
use App\Modules\Notifications\SendNotificationCommand;
use App\Modules\Statements\Application\UseCases\GetStatementForSendingUseCase;
use App\Modules\Statements\GetStatementForSendingCommand;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
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

    public function __construct($users, StatementNotificationSystemInterface $statementNotification)
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

                $sendNotificationUseCase = new SendNotificationUseCase(User: $user, text: $statement->text, statementNotificationSystem: $this->statementNotification);
                $sendNotificationUseCase->execute();
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
