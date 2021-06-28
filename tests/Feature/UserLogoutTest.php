<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_user_out()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->json('GET', route('logout'))
            ->assertStatus(204);
    }

    public function test_it_deletes_all_user_tokens()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $this->json(
            'POST',
            route('login'),
            [
            'email' => $user->email,
            'password' => 'password',
            ]
        );
        $this->actingAs($user)
            ->json('GET', route('logout'));

        $this->assertDatabaseMissing(
            'personal_access_tokens',
            [
                'tokenable_id' => '1',
            ]
        );
    }
}
