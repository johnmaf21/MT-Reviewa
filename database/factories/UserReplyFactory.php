<?php

namespace Database\Factories;

use App\Models\MediaUser;
use App\Models\UserComment;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $originalComment = UserComment::all()->random();
        $replyUser = MediaUser::where('media_id',$originalComment->review->media_id)
                                    ->where('media_type',$originalComment->review->media_type)->get()->random();
        return [
            'comment' => $this->faker->sentence(),
            'user_comment_id' => $originalComment->id,
            'user_id' => $replyUser->user->id,
            'date_posted' => new DateTime(),
        ];
    }
}
