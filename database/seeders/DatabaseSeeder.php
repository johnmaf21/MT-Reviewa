<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // \App\Models\User::factory(10)->create();

         $this->call([
             UserSeeder::class,
             ReviewSeeder::class,
             FollowerSeeder::class,
             MediaUserSeeder::class,
             UserCommentSeeder::class,
             UserReplySeeder::class,
             ListTypeSeeder::class,
             WatchlistSeeder::class,
             MovieWatchlistSeeder::class,
             TVWatchlistSeeder::class,
         ]);

    }

}
