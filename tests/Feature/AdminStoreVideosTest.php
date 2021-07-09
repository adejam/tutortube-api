<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AdminStoreVideosTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $_url;

    public function setUp(): void // a setup is called whenever a test is instantiated
    {
        parent::setUp();
        $this->_url = 'https://youtube.com/watch?v=1sTux4ys3iE';
    }

    private function _videoBaseData()
    {
        return[
        'url' => $this->_url,
        'description' => 'test',
        'title' => 'Random title',
        'category' => 'html'
        ];
    }

    public function test_it_allows_admins_only()
    {
        $user = User::factory()->create();
        $data = $this->_videoBaseData();
        $this->actingAs($user)
            ->json('POST', route('video.add'), $data)
            ->assertStatus(401);
    }

    public function test_that_it_creates_a_new_video(): void
    {
        $this->withoutExceptionHandling();
        $url = $this->_url;
        $adminUser = User::factory()->admin()->create();
        $data = $this->_videoBaseData();
        $response = $this->actingAs($adminUser)->json(
            'POST',
            route('video.add'),
            $data
        )->assertStatus(201);
    }
    
    public function test_that_it_returns_video_in_response(): void
    {
        $url = $this->_url;
        $user = User::factory()->admin()->create();
        $data = $this->_videoBaseData();

        $response = $this->actingAs($user)->json(
            'POST',
            route('video.add'),
            $data
        );

        $response->assertJson(
            function (AssertableJson $json) use ($data) {
                $json
                    ->has('video')
                    ->has('video.user_id')
                    ->where('video.url', $data['url'])
                    ->etc();
            }
        )->assertStatus(201);
    }

    public function it_validates_required_fields(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->json('POST', route('video.add'), [])
            ->assertStatus(422)
            ->assertJson(
                function (AssertableJson $json) {
                    dd($json);
                    $json->has('errors.url')
                        ->has('errors.title')
                        ->has('errors.description')
                        ->has('errors.category')
                        ->etc();
                }
            );
    }
}
