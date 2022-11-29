<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GetApiData;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $mediaTypes = ["movie","tv"];
        $mediaType = $mediaTypes[random_int(0,1)];
        $getApiData = new GetApiData($mediaType);

        $mediaId = "";
        $review = null;

        while($mediaId === "" || $review !== null){
            $mediaData = $getApiData->getTrendingData((string)random_int(1,10));
            $options = count($mediaData["results"])-1;
            $mediaId = $mediaData["results"][random_int(0,$options)]["id"];
            $review = Review::where('media_type', $mediaType)
                                ->where('media_id', $mediaId)
                                ->first();
        }

        return [
            'media_id' => $mediaId,
            'media_type' => $mediaType,
            'total_comments' => 0,
            'total_reactions' => 0,
        ];
    }
}
