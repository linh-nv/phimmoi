<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $movie = Movie::factory()->create();

        return [
            'movie_slug' => $movie->slug,
            'name' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'link_embed' => $this->faker->url,
        ];
    }
}
