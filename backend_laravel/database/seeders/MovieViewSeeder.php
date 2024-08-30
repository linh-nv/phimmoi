<?php

namespace Database\Seeders;

use App\Models\MovieView;
use Illuminate\Database\Seeder;

class MovieViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MovieView::factory()->count(10)->create();
    }
}
