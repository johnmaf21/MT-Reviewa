<?php

namespace Database\Factories;

use App\Models\MovieWatchlist;
use App\Models\Watchlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieWatchlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $movie = Watchlist::join('media_users', 'watchlists.media_user_id', '=', 'media_users.id')
                            ->where('media_users.media_type','movie')->get()->random();
        while(MovieWatchlist::where('watchlist_id','=',$movie->id)->first() !== null){
            $movie = Watchlist::join('media_users', 'watchlists.media_users_id', '=', 'media_users.id')
                ->where('media_users.media_type', '=', 'movie')->get()->random();
        }
        return [
            'watchlist_id' => $movie->id,
        ];
    }
}
