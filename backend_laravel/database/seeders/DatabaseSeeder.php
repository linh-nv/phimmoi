<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            ProvinceSeeder::class,
            DistrictSeeder::class,
            WardSeeder::class,
            CategorySeeder::class,
            GenreSeeder::class,
            CountrySeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            MovieSeeder::class,
            EpisodeSeeder::class,
            MovieGenreSeeder::class,
        ]);
    }
}
