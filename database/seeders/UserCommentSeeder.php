<?php

namespace Database\Seeders;

use App\Models\UserComment;
use Illuminate\Database\Seeder;

class UserCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserComment::factory()
                ->count(40)
                ->create();
    }
}
