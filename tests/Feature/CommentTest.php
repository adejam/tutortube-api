<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_allows_only_authenticated_users_only()
    {
        $this->json('POST', route('comment.add'))
            ->assertStatus(401);
    }

    public function test_it_validates_required_fields()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('POST', route('comment.add'), [])
            ->assertJson(
                function (AssertableJson $json) {
                    $json
                        ->has('errors')
                        ->has('errors.video_id')
                        ->has('errors.comment')
                        ->etc();
                }
            )
            ->assertStatus(422);
    }

    public function test_it_adds_a_new_comment()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();
        $postData = [
            'video_id' => $video->video_id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($user)->json('POST', route('comment.add'), $postData)
            ->assertJson(
                function (AssertableJson $json) use ($postData) {
                    $json
                        ->has('comment')
                        ->has('comment.user_id')
                        ->where('comment.comment', $postData['comment'])
                        ->etc();
                }
            )->assertStatus(201);
    }
}
