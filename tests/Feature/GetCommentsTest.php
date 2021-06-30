<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetCommentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_allows_authenticated_users_only()
    {
        $this->json('GET', route('comment.get', ['video_id' => 'null']))
            ->assertStatus(401);
    }

    public function test_that_it_shows_all_video_comments()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $video = Video::factory()->create();
        Comment::factory()->count(5)->create(['video_id' => $video->video_id]);
        $response = $this->actingAs($user)->json('GET', route('comment.get', ['video_id' => $video->video_id]));
        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                        $json->has('comments', 5)
                    ->has(
                        'comments.0',
                        fn ($json) =>
                        $json->where('video_id', $video->video_id)
                            ->etc()
                    )
            );
        ;
    }

    public function test_that_it_aborts_the_page_if_video_id_does_not_exist()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $video = Video::factory()->create();
        Comment::factory()->count(5)->create(['video_id' => $video->video_id]);
        $response = $this->actingAs($user)->json('GET', route('comment.get', ['video_id' => 'ddd']));
        $response->assertStatus(404);
    }
}
