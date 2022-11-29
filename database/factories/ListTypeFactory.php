<?php

namespace Database\Factories;

use App\Models\ListType;
use App\Models\MediaUser;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $watchlists = array('Tv Show Watchlist', 'Movie Watchlist');
        $data = $this->getData($watchlists);

        while(ListType::where('user_id',$data["user"])->where('name',$data["watchlist"])->first() !==null){
            $data = $this->getData($watchlists);
        }
        return [
            'name' => $data["watchlist"],
            'user_id' => $data["user"],
            'date_created' => new DateTime(),
            'date_updated' => new DateTime(),
        ];
    }

    private function getData($watchlists){
        return ['user' => MediaUser::all()->random()->user->id,
                'watchlist' => $watchlists[random_int(0,1)]];
    }
}
