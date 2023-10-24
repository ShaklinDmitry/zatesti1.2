<?php

namespace Tests\Feature\StatementSendingSchedule;

use App\Models\StatementSendingSchedule;
use App\Models\User;
use App\Modules\StatementSendingSchedule\Application\DTOs\StatementSendingScheduleDTO;
use App\Modules\StatementSendingSchedule\Application\UseCases\GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand;
use App\Modules\StatementSendingSchedule\Infrastructure\Repositories\StatementSendingScheduleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUsersWhoShouldBeNotifiedAtTheCurrentTimeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_get_users_who_should_be_notified_at_the_current_time()
    {
        $currentTime = date("H:i");

        $userFirst = User::factory()->create();
        $userSecond = User::factory()->create();

        $firstStatementSendingSchedule = StatementSendingSchedule::factory()->create([
            "guid" => uniqid(),
            'user_id' => $userFirst,
            'exact_time' => $currentTime
        ]);

        $secondStatementSendingSchedule = StatementSendingSchedule::factory()->create([
            "guid" => uniqid(),
            'user_id' => $userSecond,
            'exact_time' => $currentTime
        ]);

        $statementSendingScheduleRepository = new StatementSendingScheduleRepository();

        $getUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand = new GetStatementSendingScheduleForUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand($statementSendingScheduleRepository);
        $statementSendingScheduleDTOCollection = $getUsersWhoShouldBeNotifiedAtTheCurrentTimeCommand->execute($currentTime);

        $expectedStatementSendingScheduleDTOCollection = [
            '0' => new StatementSendingScheduleDTO($firstStatementSendingSchedule->guid, $firstStatementSendingSchedule->user_id, $firstStatementSendingSchedule->exact_time),
            '1' => new StatementSendingScheduleDTO($secondStatementSendingSchedule->guid, $secondStatementSendingSchedule->user_id, $secondStatementSendingSchedule->exact_time),
        ];

        $this->assertEquals($expectedStatementSendingScheduleDTOCollection, $statementSendingScheduleDTOCollection->getCollection());
    }
}
