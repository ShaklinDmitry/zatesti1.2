<?php

namespace Tests\Feature\Notifications;

use Tests\TestCase;

class SendWeeklyReportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_weekly_report()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
