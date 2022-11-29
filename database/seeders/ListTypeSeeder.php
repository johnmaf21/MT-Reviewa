<?php

namespace Database\Seeders;

use App\Models\ListType;
use Illuminate\Database\Seeder;

class ListTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ListType::factory()
                ->count(30)
                ->create();
    }
}
