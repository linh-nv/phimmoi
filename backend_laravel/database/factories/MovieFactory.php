<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\MovieStatus;
use App\Models\Country;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->sentence(3),
            'origin_name' => $this->faker->word,
            'content' => $this->faker->paragraph,
            'type' => $this->faker->numberBetween(1, 3),
            'status' => $this->faker->numberBetween(1, 2),
            'poster_url' => $this->faker->imageUrl(),
            'thumb_url' => $this->faker->imageUrl(),
            'is_copyright' => (bool) $this->faker->boolean,
            'sub_docquyen' => (bool) $this->faker->boolean,
            'chieurap' => (bool) $this->faker->boolean,
            'trailer_url' => $this->faker->url,
            'time' => $this->faker->time,
            'episode_current' => $this->faker->randomNumber(2),
            'episode_total' => $this->faker->randomNumber(2),
            'quality' => $this->faker->numberBetween(1, 3),
            'lang' => $this->faker->languageCode,
            'notify' => $this->faker->sentence,
            'showtimes' => $this->faker->sentence,
            'year' => $this->faker->year,
            'view' => $this->faker->randomNumber,
            'actor' => $this->faker->name,
            'director' => $this->faker->name,
            'country_id' => Country::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
