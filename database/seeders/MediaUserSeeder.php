<?php

namespace Database\Seeders;

use App\Models\MediaUser;
use Illuminate\Database\Seeder;

class MediaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MediaUser::factory()
                ->count(80)
                ->create();
    }
}
