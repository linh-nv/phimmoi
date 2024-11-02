<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'user_id' => User::factory(),
            'address' => $this->faker->address,
            'province_id' => Province::factory(),
            'district_id' => District::factory(),
            'ward_id' => Ward::factory(),
        ];
    }
}
