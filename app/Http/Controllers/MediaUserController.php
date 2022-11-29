<?php

namespace App\Http\Controllers;

use App\Models\EpisodeUser;
use App\Models\GetApiData;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\MediaUser;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class MediaUserController extends Controller
{
    public function createMediaUser(User $user, Int $mediaId, String $mediaType, DateTime $dateStarted){
        $mediaUser = new MediaUser;
        $mediaUser->user()->associate($user);
        $mediaUser->media_id = $mediaId;
        $mediaUser->media_type = $mediaType;
        $mediaUser->last_watched = $dateStarted;
        $mediaUser->completion = 0.0;
        $mediaUser->is_completed = false;
        $mediaUser->has_liked = false;
        $mediaUser->has_reaction = false;
        $mediaUser->save();

        return $mediaUser;
    }

    public function createReview(Int $mediaId, String $mediaType){
        $review = new Review;
        $review->media_id = $mediaId;
        $review->media_type = $mediaType;
        $review->total_comments = 0;
        $review->total_reactions = 0;
        $review->save();
        return $review;
    }

    public function calcTvShowCompletion(MediaUser $mediaUser)
    {
        $getApiData = new GetApiData('tv');

        $currentEpisode = $mediaUser->current_episode;

        if ($currentEpisode === null){return 0;}

        $tvShowData = $getApiData->getMediaData((string)$mediaUser->media_id);
        $totalEpisodes = $tvShowData['number_of_episodes'];
        $maxSeason = $tvShowData['number_of_seasons'];

        $seasonData = $getApiData->getSeasonData((string)$mediaUser->id, (string)$currentEpisode->season);
        $currentSeason = $currentEpisode->season;
        $unwatchedTotal = count($seasonData['episodes']);
        $currentSeason++;

        while ($currentSeason<=$maxSeason){
            $seasonData = $getApiData->getSeasonData((string)$mediaUser->id, (string)$currentSeason);
            $unwatchedTotal += count($seasonData['episodes']);
            $currentSeason++;
        }

        return (($totalEpisodes-$unwatchedTotal)/$totalEpisodes)*100;
    }

    public function createEpisodeUser(Int $episodeId, MediaUser $mediaUser, Int $season, Int $episode){
        $episodeUser = new EpisodeUser;
        $episodeUser->is_watched = false;
        $episodeUser->date_completed = null;
        $episodeUser->episode_id = $episodeId;
        $episodeUser->season = $season;
        $episodeUser->episode = $episode;
        $episodeUser->has_liked = false;
        $episodeUser->mediaUser()->associate($mediaUser);
        $episodeUser->save();
        return $episodeUser;
    }

    public function isValidSeason(GetApiData $getApiData, Int $media_id, Int $season){
        $seasonEpisodes = $getApiData->getSeasonData((string)$media_id,(string)$season);
        while(!array_key_exists("episodes", $seasonEpisodes)){
            $season++;
            $seasonEpisodes = $getApiData->getSeasonData((string)$media_id,(string)$season);
        }
        return array($season,$seasonEpisodes);
    }

    public function getCurrentEpisode(Int $mediaUserId){
        $maxSeason = EpisodeUser::where('media_user_id', $mediaUserId)
                                    ->where('has_watched', true)->max('season');
        if ($maxSeason === null) {
            return null;
        }

        return EpisodeUser::where('media_user_id', '=', $mediaUserId)
                            ->where('has_watched', '=', true)
                            ->where('season', '=', $maxSeason)
                            ->orderBy('episode', 'desc')
                            ->first();
    }

    public function createPreviousEpisodeUsers(MediaUser $mediaUser, Int $season, Int $episode){
        $getApiData = new GetApiData('tv');
        $currentEpisode = 1;
        $getValidSeason = $this->isValidSeason($getApiData,$mediaUser->media_id,0);
        $seasonEpisodes = $getValidSeason[1];
        $currentSeason = $getValidSeason[0];
        $maxEpisode = count($seasonEpisodes['episodes']);

        while($currentSeason <= $season){

            if(EpisodeUser::where('media_user_id', $mediaUser->id)->where('episode', $currentEpisode)
                    ->where('season', $currentEpisode)->first() === null){
                $episodeData = $getApiData->getEpisodeData((string)$mediaUser->media_id, (string)$currentSeason, (string)$currentEpisode);
                $this->createEpisodeUser($episodeData['id'], $mediaUser, $currentSeason, $currentEpisode);
            }

            if ($currentEpisode === $episode && $currentSeason === $season){
               break;
            }
            $currentEpisode++;
            if ($currentEpisode > $maxEpisode){
                $currentSeason++;
                $currentEpisode = 1;
                $seasonEpisodes = $getApiData->getSeasonData((string)$mediaUser->media_id,(string)$currentSeason);
                $maxEpisode = count($seasonEpisodes['episodes']);
            }
        } return EpisodeUser::where('media_user_id', $mediaUser)->where('season', '>', $season)
            ->orWhere(function($query,$mediaUser, $season, $episode) {
                $query->where('media_user_id', $mediaUser)
                    ->where('season', $season)
                    ->where('episode', '<=', $episode);})->get();

    }

    public function createFutureEpisodeUsers(MediaUser $mediaUser, Int $season, Int $episode){
        $getApiData = new GetApiData('tv');
        $currentEpisode = $episode;
        $seasonEpisodes = $getApiData->getSeasonData((string)$mediaUser->media_id,(string)$season);
        $currentSeason = $season;


        $tvShowData = $getApiData->getMediaData($mediaUser->media_id);
        $maxSeason = $tvShowData['number_of_seasons'];
        $maxEpisode = count($seasonEpisodes['episodes']);

        while($currentSeason <= $maxSeason){
            $episodeData = $getApiData->getEpisodeData((string)$mediaUser->media_id, (string)$currentSeason, (string)$currentEpisode);
            if (new DateTime($episodeData['air_date']) > new DateTime()){
                break;
            }

            if(EpisodeUser::where('media_user_id',$mediaUser->id)->where('episode', $currentEpisode)
                    ->where('season', $season)->first() === null){
                $this->createEpisodeUser($episodeData['id'], $mediaUser, $currentSeason, $currentEpisode);
            }

            if ($currentEpisode === $episode && $currentSeason === $season){
                break;
            }
            $currentEpisode++;
            if ($currentEpisode > $maxEpisode){
                $currentSeason++;
                $seasonEpisodes = $getApiData->getSeasonData((string)$mediaUser->media_id,(string)$currentSeason);
                $maxEpisode = count($seasonEpisodes['episodes']);
            }
        } return EpisodeUser::where('media_user_id',$mediaUser)->where('season', '<', $season)
            ->orWhere(function($query,$mediaUser, $season, $episode) {
                $query->where('media_user_id', $mediaUser)
                    ->where('season', $season)
                    ->where('episode', '>=', $episode);})->get();

    }

    public function updateEpisodeUser(EpisodeUser $episodeUser, Boolean $is_watched){
        $episodeUser->is_watched = $is_watched;
        if ($is_watched){
            $episodeUser->date_completed = new DateTime;
        } else {
            $episodeUser->date_completed = null;
        }
        $episodeUser->save();
        return $episodeUser;
    }

    public function updateCurrentEpisode(MediaUser $mediaUser){
        $mediaUser->current_episode = $this->getCurrentEpisode($mediaUser->id);
        $mediaUser->save();
        return $mediaUser;
    }

}
