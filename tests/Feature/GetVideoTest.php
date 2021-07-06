<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetVideoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_allows_authenticated_users_only()
    {
        $this->json('GET', route('video.get', ['category' => 'html', 'video_id' => null]))
            ->assertStatus(401);
    }

    public function test_that_it_shows_list_of_videos_from_a_category()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Video::factory()->count(5)->create();
        Video::factory()->count(3)->create(['category' => 'css']);
        $response = $this->actingAs($user)->json('GET', route('video.get', ['category' => 'css']));
        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('videos', 3)
                    ->has(
                        'videos.0',
                        fn ($json) =>
                            $json->where('category', 'css')
                            ->etc()
                    )
            );
        ;
    }

    public function test_that_it_returns_404_when_category_param_does_not_exist()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Video::factory()->count(5)->create();
        $response = $this->actingAs($user)->json('GET', route('video.get', ['category' => 'cs']));
        $response->assertStatus(404);
    }

    public function test_that_it_returns_404_when_video_id_param_does_not_exist()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $video = Video::factory()->create(['video_id' => 'dddddd']);
        $response = $this->actingAs($user)->json('GET', route('video.get.video', ['category' => 'html', 'video_id' => 'dddd']));
        $response->assertStatus(404);
    }

    public function test_it_shows_a_single_video_data()
    {
        $video = Video::factory()->create(['video_id' => 'dddddd']);
        $user = User::factory()->create();
        Comment::factory()->count(5)->create(['video_id' => $video->video_id]);

        $this->actingAs($user)->json('GET', route('video.get.video', ['category' => 'html', 'video_id' => 'dddddd']))
            ->assertStatus(200)
            ->assertJson(
                function (AssertableJson $json) use ($video) {
                    $json->where('video.video_id', $video->video_id)
                        ->where('video.category', $video->category)
                        ->has('comments', 5)
                        ->has(
                            'comments.0',
                            fn ($json) =>
                            $json->where('video_id', $video->video_id)
                                ->etc()
                        )
                        ->etc();
                }
            );
    }
}
