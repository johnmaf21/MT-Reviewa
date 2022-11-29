<?php

namespace Database\Seeders;

use App\Models\UserReply;
use Illuminate\Database\Seeder;

class UserReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserReply::factory()
                ->count(50)
                ->create();
    }
}
