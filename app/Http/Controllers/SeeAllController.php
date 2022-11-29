<?php

namespace App\Http\Controllers;

use App\Models\GetApiData;
use App\Models\MediaUser;
use App\Models\TVWatchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeeAllController extends Controller
{
    public function addToWatchlist(Request $request, Int $mediaId){
        $listTypeController = new ListTypeController;
        $listTypeController->addToMovieWatchlist($mediaId, Auth::user());
        return back()->with("Added to watchlist");

    }

    public function removeFromWatchlist(Request $request, Int $mediaId)
    {
        $listTypeController = new ListTypeController;
        $listTypeController->removeFromMovieWatchlist($mediaId, Auth::user());
        return back()->with("Removed from watchlist");
    }



    public function openSpecificMedia(Request $request, Int $mediaId, String $mediaType){
        if ($mediaType === "tv") {
            $tvShowController = new TvShowsController();
            return $tvShowController->openSpecificTvShow($request,$mediaId);
        }

        if($mediaType === "movie") {
           $moviesController = new MoviesController();
           return $moviesController->openSpecificMovie($request, $mediaId);
        }

        return back()->withErrors('Incorrect Media Type');

    }

    public function getNewPage(String $type, String $mediaType, Int $page, String $typeQuery='', Int $id=0){
        $mediaUsers = [];
        $results = [];
        if($type !== 'genre') {
            $typeQuery = $type;
        }

        $getApiData = new GetApiData($mediaType);

        $mediaUser = [];
        if(!Auth::guest()){
            if($mediaType === "all"){
                $mediaUser =  MediaUser::where('user_id',Auth::user()->id)->get();
            } else {
                $mediaUser =  MediaUser::where('user_id',Auth::user()->id)->where('media_type',$mediaType)->get();
            }
        }

        foreach($mediaUser as $media) {
            $mediaUsers[$media->media_id] = $media;
            if($type === "completed"){
                if($media->is_completed) {
                    $getApiData->mediaType = $media->media_type;
                    $completed[$media->media_id] = $getApiData->getMediaData((string)$media->media_id);
                }
            }
        }
        $getApiData->mediaType = $mediaType;

        if($type !== "completed"){
            if ($type === "genre") {
                $results = $getApiData->getDiscoverMedia((string)$id, (string)$page)['results'];
            } else {
                $getData = [
                    'Currently On Air' => $getApiData->getOnAirData((string)$page),
                    'Trending' => $getApiData->getTrendingData((string)$page)['results'],
                    'Top Rated' => $getApiData->getTopRatedData((string)$page)['results'],
                    'Popular' => $getApiData->getPopularData((string)$page)['results'],
                    'In Theatres' => $getApiData->getInTheatresData((string)$page)['results'],
                    'Upcoming' => $getApiData->getUpcomingData((string)$page)['results'],
                ];

                $results = $getData[$type];
            }
        }

        return view('seeAll/index', [
            'results' => $results,
            'mediaUsers' => $mediaUsers,
            'type' => $type,
            'typeQuery' => $typeQuery,
            'id' => $id
        ]);

    }
}
