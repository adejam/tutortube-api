<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $video = Video::factory()->create();
        return [
            'user_id' => User::factory()->create()->id,
            'video_id' => $video->video_id,
            'comment' => $this->faker->sentence(),
        ];
    }
}
