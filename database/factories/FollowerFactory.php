<?php

namespace Database\Factories;

use App\Models\Follower;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->random()->id;
        $follower_id = User::where('id', '!=', $user_id)->get()->random()->id;
        while(Follower::where('user_id',$user_id)->where('followers_id',$follower_id)->first() !== null){
            $user_id = User::all()->random()->id;
            $follower_id = User::where('id', '!=', $user_id)->get()->random()->id;
        }

        return [
            'date_added' => new DateTime(),
            'user_id' => $user_id,
            'followers_id' => $follower_id,
        ];
    }
}
