<?php

namespace Tests\Feature;

use App\Models\Statement;
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


    /**
     * Тест на изменения типа высказывания с лучшего на обычное
     * @return void
     */
    public function test_turn_best_statement_into_normal_statement(){
        $user = User::factory()->create();

        $statement = Statement::factory()->create([
                                            'user_id' => $user->id,
                                            'is_best_statement' => 1
                                            ]);

        $response = $this->actingAs($user)->patch('api/beststatements/'.$statement->id.'/make-normalstatement');


        $response->assertJson(
            [
                "data" => [
                    "message" => "Statement now is normal.",
                ]
            ]
        );


        $statement = Statement::find($statement->id)->first();

        $this->assertSame(0, $statement->is_best_statement);
    }

}
