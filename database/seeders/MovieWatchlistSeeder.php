<?php

namespace Database\Seeders;

use App\Models\MovieWatchlist;
use Illuminate\Database\Seeder;

class MovieWatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovieWatchlist::factory()
                ->count(15)
                ->create();
    }
}
