<?php

namespace Database\Factories;

use App\Models\TVWatchlist;
use App\Models\Watchlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class TVWatchlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tv = Watchlist::join('media_users', 'watchlists.media_user_id', '=', 'media_users.id')
            ->where('media_users.media_type','tv')->get()->random();
        while(TVWatchlist::where('watchlist_id',$tv->id)->first() !== null){
            $tv = Watchlist::join('media_users', 'watchlists.media_user_id', '=', 'media_users.id')
                ->where('media_users.media_type','tv')->get()->random();
        }
        return [
            'watchlist_id' => $tv->id,
        ];
    }
}
