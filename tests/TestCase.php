<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function checkAllowedToAdmin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)
            ->json('POST', route('video.add'))
            ->assertStatus(401);
    }
}
