<?php

namespace Database\Factories;

use App\Enums\DistrictType;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\District>
 */
class DistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'district_name' => $this->faker->city,
            'district_type' => $this->faker->randomElement(DistrictType::cases())->value,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'province_id' => Province::factory(),
        ];
    }
}
