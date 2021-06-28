<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sends_user_token_on_correct_credentials()
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
        )->assertStatus(200)->assertJson(
            function (AssertableJson $json) use ($user) {
                $json->has('token')
                    ->where('username', $user->name)
                    ->etc();
            }
        );
    }

    public function test_it_sends_the_user_role()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create(['role' => 'admin']);

        $this->json(
            'POST',
            route('login'),
            [
            'email' => $user->email,
            'password' => 'password',
            ]
        )->assertStatus(200)->assertJson(
            function (AssertableJson $json) use ($user) {
                $json->has('token')
                    ->where('role', 'admin')
                    ->etc();
            }
        );
    }

    public function test_it_validates_wrong_password()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create(['password' => 'mmmmmmmm']);
        $this->json(
            'POST',
            route('login'),
            [
            'email' => $user->email,
            'password' => 'random',
            ]
        )->assertStatus(422)->assertJson(
            function (AssertableJson $json) use ($user) {
                $json->has('error')
                    ->etc();
            }
        );
    }

    public function test_it_adds_a_token_for_verification_onlogin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $resp = $this->json(
            'POST',
            route('login'),
            [
            'email' => $user->email,
            'password' => 'password',
            ]
        );
        $data = json_decode($resp->getContent(), true);
        
        $this->assertDatabaseHas(
            'personal_access_tokens',
            [
                'tokenable_id' => '1',
                'name' => $user->name.'Logs in',
            ]
        );
    }

    public function test_it_validates_required_fields()
    {
        $this->json('POST', route('login'), [])
            ->assertStatus(422)
            ->assertJson(
                function (AssertableJson $json) {
                    $json->has('errors.email')
                        ->has('errors.password')
                        ->etc();
                }
            );
    }
}
