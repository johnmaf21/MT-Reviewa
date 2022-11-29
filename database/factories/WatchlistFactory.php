<?php

namespace Database\Factories;

use App\Models\ListType;
use App\Models\MediaUser;
use App\Models\Watchlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WatchlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $watchlistTypes = ['movie' => 'Movie Watchlist', 'tv' => 'Tv Show Watchlist'];
        $data = $this->getData($watchlistTypes);
        while($data["mediaUsers"]->isEmpty()){
            $data = $this->getData($watchlistTypes);
        }
        $mediaUser = $data["mediaUsers"]->random();

        while(Watchlist::where('list_type_id',$data["listType"]->id)->where('media_user_id',$mediaUser->id)->first() !== null){
            $data = $this->getData($watchlistTypes);
            while($data["mediaUsers"]->isEmpty()){
                $data = $this->getData($watchlistTypes);
            }
            $mediaUser = $data["mediaUsers"]->random();
        }
        return [
            'list_type_id' => $data["listType"]->id,
            'media_user_id' =>$mediaUser->id,
        ];
    }

    private function getData($watchlistTypes){
        $watchlist = array('movie','tv')[random_int(0,1)];
        $listType = ListType::where('name',$watchlistTypes[$watchlist])->get()->random();
        $mediaUsers = MediaUser::where('media_type',$watchlist)->where('user_id',$listType->user->id)->get();

        return ['watchlist' => $watchlist,
                'listType' => $listType,
                'mediaUsers' => $mediaUsers];
    }
}
