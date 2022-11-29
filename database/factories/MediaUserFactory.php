<?php

namespace Database\Factories;

use App\Models\GetApiData;
use App\Models\MediaUser;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $user = User::all()->random();

        $review = Review::where('media_type','!=','episode')->get()->random();
        while(MediaUser::where('media_id', $review->media_id)
                ->where('media_type', $review->media_type)
                ->where('user_id', $user->id)->first() !== null){
            $review = Review::where('media_type','!=','episode')->get()->random();
        }

        return [
            'media_id' => $review->media_id,
            'media_type' => $review->media_type,
            'last_watched' => null,
            'is_completed' => false,
            'has_liked' => false,
            'has_reaction' => false,
            'completion' => 0,
            'user_id' => $user->id,
            'current_episode' => null,

        ];
    }
}
