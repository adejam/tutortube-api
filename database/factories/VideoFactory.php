<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'url' => $this->faker->url(),
            'video_id' => $this->faker->uuid(),
            'description' => $this->faker->paragraph(),
            'title' => $this->faker->sentence(),
            'category' => 'html',
        ];
    }
}
