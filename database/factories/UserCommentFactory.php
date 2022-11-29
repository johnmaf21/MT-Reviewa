<?php

namespace Database\Factories;

use App\Models\GetApiData;
use App\Models\MediaUser;
use App\Models\Review;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCommentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $data = $this->getData();
        $totalComments = $data["totalComments"];

        while($totalComments < 0){
            $data = $this->getData();
            $totalComments = $data["totalComments"];
        }
        $comment = random_int(0,$data["totalComments"]);
        if ($data["reviewComments"]["results"][$comment]["author_details"]["avatar_path"] !== null){
            $data["mediaUser"]->user->profile_pic = $data["reviewComments"]["results"][$comment]["author_details"]["avatar_path"];
            $data["mediaUser"]->user->save();
        }

        return [
            'comment' => $data["reviewComments"]["results"][$comment]["content"],
            'date_posted' => new DateTime(),
            'user_id' => $data["mediaUser"]->user->id,
            'review_id' => $data["review"]->id,
        ];
    }

    private function getData()
    {
        $mediaUser = MediaUser::all()->random();
        $getApiData = new GetApiData($mediaUser->media_type);
        $reviewComments = $getApiData->getReviewComments((string)$mediaUser->media_id, (string)1);

        return ['mediaUser' => $mediaUser,
            'review' => Review::where('media_id',$mediaUser->media_id)->where('media_type',$mediaUser->media_type)->first(),
            'reviewComments' => $reviewComments,
            'totalComments' => count($reviewComments["results"]) - 1];
    }

}
