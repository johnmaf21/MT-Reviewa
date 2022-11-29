<?php

namespace Database\Seeders;

use App\Models\TVWatchlist;
use Illuminate\Database\Seeder;

class TVWatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TVWatchlist::factory()
                ->count(15)
                ->create();
    }
}
