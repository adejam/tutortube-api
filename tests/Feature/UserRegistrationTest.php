<?php

namespace Tests\Feature;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function _userRegistrationBaseData()
    {
        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
    }

    public function test_it_allows_a_user_to_register()
    {
        $this->withoutExceptionHandling();
        $user = $this->_userRegistrationBaseData();

        $response = $this->json(
            'POST',
            route('register'),
            $user
        )->assertStatus(201);

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $user['email'],
                'name' => $user['name'],
                ]
        );
    }

    public function test_it_registers_a_user_with_verified_as_null()
    {
        $user = $this->_userRegistrationBaseData();

        $this->json('POST', route('register'), $user);

        $this->assertDatabaseHas(
            'users',
            [
            'email' => $user['email'],
            'email_verified_at' => null
            ]
        );
    }

    public function test_it_validates_required_fields()
    {
        $this->json('POST', route('register'), [])
            ->assertStatus(422)
            ->assertJson(
                function (AssertableJson $json) {
                    $json->has('errors.email')
                        ->has('errors.password')
                        ->has('errors.name')
                        ->etc();
                }
            );
    }

    public function test_it_validates_passwords_are_same()
    {
        $postData = $this->_userRegistrationBaseData();
        $postData['password_confirmation'] = 'cpassword';

        $this->json('POST', route('register'), $postData)
            ->assertStatus(422)
            ->assertJson(
                function (AssertableJson $json) {
                    $json->has('errors.password')
                        ->etc();
                }
            );
    }

    public function test_it_validates_unique_email()
    {
        $user = User::factory()->create();
        $postData = $this->_userRegistrationBaseData();
        $postData['email'] = $user->email;

        $this->json('POST', route('register'), $postData)
            ->assertStatus(422)
            ->assertJson(
                function (AssertableJson $json) {
                    $json->has('errors.email')
                        ->etc();
                }
            );
    }

    public function test_it_adds_a_token_for_verification()
    {
        $postData = $this->_userRegistrationBaseData();

        $resp = $this->json('POST', route('register'), $postData);

        $data = json_decode($resp->getContent(), true);
        $this->assertDatabaseHas(
            'personal_access_tokens',
            [
                'tokenable_id' => '1',
                'name' => $data['username'].'Sign up',
            ]
        );
    }
}
