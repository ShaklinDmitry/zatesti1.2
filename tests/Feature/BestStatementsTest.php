<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserResponse;
use Database\Factories\UserResponseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BestStatementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * тест для получения лучших высказываний
     * @return void
     */
    public function test_get_best_statements(){

        $user = User::factory()->create();

        $userResponse = UserResponse::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('api/beststatements');

        $this->assertSame($response['data']['bestStatements'][0]["text"], $userResponse->text);
    }

    /**
     * тест для случая когда у пользорвателя нет высказываний
     * @return void
     */
    public function test_throw_no_best_statements_exception(){

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('api/beststatements');

        $this->assertSame($response['error']['message'], 'there no best responses for this user');
    }


    /**
     * Тест для удаления лучших высказываний
     * @return void
     */
    public function test_delete_best_statement(){
        $user = User::factory()->create();

        $userResponse = UserResponse::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, UserResponse::all());

        $this->actingAs($user)->delete('api/beststatements/'.$userResponse->id);

        $this->assertCount(0, UserResponse::all());
    }
}
