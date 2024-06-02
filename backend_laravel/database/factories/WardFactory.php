<?php

namespace Database\Factories;

use App\Enums\WardType;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ward>
 */
class WardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'ward_name' => $this->faker->streetName,
            'ward_type' => $this->faker->randomElement(WardType::cases())->value,
            'district_id' => District::factory(),
        ];
    }
}
