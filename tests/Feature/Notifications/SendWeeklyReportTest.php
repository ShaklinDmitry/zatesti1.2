<?php

namespace Tests\Feature\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendWeeklyReportTest extends TestCase
{
    use RefreshDatabase;
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
