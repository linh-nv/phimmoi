<?php

namespace Database\Seeders;

use App\Models\MovieUser;
use Illuminate\Database\Seeder;

class MovieUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MovieUser::factory()->count(10)->create();
    }
}
