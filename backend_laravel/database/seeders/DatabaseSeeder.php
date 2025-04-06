<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ProvinceSeeder::class,
            // DistrictSeeder::class,
            // WardSeeder::class,
            // CategorySeeder::class,
            // GenreSeeder::class,
            // CountrySeeder::class,
            AdminSeeder::class,
            // UserSeeder::class,
            // AddressSeeder::class,
            // MovieSeeder::class,
            // EpisodeSeeder::class,
            // MovieGenreSeeder::class,
            // MovieViewSeeder::class,
            // MovieUserSeeder::class,
        ]);
    }
}
