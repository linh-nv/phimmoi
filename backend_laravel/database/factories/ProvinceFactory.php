<?php

namespace Database\Factories;

use App\Enums\ProvinceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Province>
 */
class ProvinceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'province_name' => $this->faker->city,
            'province_type' => $this->faker->randomElement(ProvinceType::cases())->value,
        ];
    }
}
