<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MediaUserController;
use App\Models\EpisodeUser;
use App\Models\GetApiData;
use App\Models\MediaUser;
use App\Models\MovieWatchlist;
use App\Models\Review;
use App\Models\TVWatchlist;
use App\Models\UserComment;
use App\Models\UserReply;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\ListTypeController;
use Illuminate\Support\Facades\Auth;


class TvShowsController extends Controller
{
    const MEDIA_TYPE = "tv";

    public function index(){
         // Display all the movies per genre
         $getApiData = new GetApiData(self::MEDIA_TYPE);

         $trending = $getApiData->getTrendingData((string)1);
         $topRated = $getApiData->getTopRatedData((string)1);
         $popular = $getApiData->getPopularData((string)1);
         $onAir = $getApiData->getOnAirData((string)1);

         $genreTvShows = [];
         $genres = $getApiData->getGenres();
         foreach($genres['genres'] as $genre){
             $genreTvShows[$genre['name']]['tvShows'] = $getApiData->getDiscoverMedia((string)$genre['id'], (string)1)['results'];
             $genreTvShows[$genre['name']]['genre_id'] = $genre['id'];
         }


        $watchlist = [];
        $mediaUsers = [];
        $completed = [];
        if(!Auth::guest()){
            $userWatchlist = TVWatchlist::join('watchlists', 'tv_watchlists.watchlist_id', 'watchlists.id')
                ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
                ->join('media_users', 'watchlists.media_user_id', 'media_users.id')->where('list_types.user_id', Auth::user()->id)->where('media_users.is_completed', false)->get();
            foreach($userWatchlist as $movie){
                $watchlist[$movie->media_id] = $getApiData->getMediaData((string)$movie->media_id);
            }
            $mediaUser =  MediaUser::where('user_id',Auth::user()->id)->where('media_type',self::MEDIA_TYPE)->get();
            foreach($mediaUser as $media) {
                $mediaUsers[$media->media_id] = $media;
                if($media->is_completed) {
                    $completed[$media->media_id] = $getApiData->getMediaData((string)$media->media_id);
                }
            }
        }

         return view('tvShows/index', [
             'watchlist' => $watchlist,
             'tvShows' => [
                 'Currently On Air' => $onAir['results'],
                 'Trending' => $trending['results'],
                 'Top Rated' => $topRated['results'],
                 'Popular' => $popular['results'],
                 ],
             'genres' => $genreTvShows,
             'completed' => $completed,
             'mediaUsers' =>$mediaUsers,
         ]);
    }

    public function displaySeeAll(String $type, String $typeQuery='', $id=0){
        $mediaUsers = [];
        $results = [];
        if($type !== 'genre') {
            $typeQuery = $type;
        }

        $getApiData = new GetApiData(self::MEDIA_TYPE);

        $mediaUser =  MediaUser::where('user_id',Auth::user()->id)->where('media_type',self::MEDIA_TYPE)->get();
        foreach($mediaUser as $media) {
            $mediaUsers[$media->media_id] = $media;
            if($type === "completed"){
                if($media->is_completed) {
                    $completed[$media->media_id] = $getApiData->getMediaData((string)$media->media_id);
                }
            }
        }

        if($type !== "completed"){
            if($type === "watchlist"){
                $userWatchlist = TVWatchlist::join('watchlists', 'tv_watchlists.watchlist_id', 'watchlists.id')
                    ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
                    ->join('media_users', 'watchlists.media_user_id', 'media_users.id')->where('list_types.user_id', Auth::user()->id)->where('media_users.is_completed', false)->get();
                foreach($userWatchlist as $media){
                    $watchlist[$media->media_id] = $getApiData->getMediaData((string)$media->media_id);
                }
                $results = $watchlist;
            } elseif ($type === "genre") {
                $results = $getApiData->getDiscoverMedia((string)$id, (string)1)['results'];
            } else {
                $getData = [
                    'Currently On Air' => $getApiData->getOnAirData((string)1)['results'],
                    'Trending' => $getApiData->getTrendingData((string)1)['results'],
                    'Top Rated' => $getApiData->getTopRatedData((string)1)['results'],
                    'Popular' => $getApiData->getPopularData((string)1)['results'],
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

    public function addToWatchlist(Request $request, Int $tvShowId){
        $listTypeController = new ListTypeController;
        $listTypeController->addToTvWatchlist($tvShowId, Auth::user());
    }

    public function removeFromWatchlist(Request $request, Int $tvShowId)
    {
        $listTypeController = new ListTypeController;
        $listTypeController->removeFromTvWatchlist($tvShowId, Auth::user());
    }

    public function displayGenreTvShow(Request $request, String $genre, Int $genreId, Int $page){
        $getApiData = new GetApiData(self::MEDIA_TYPE);
        $tvShows = $getApiData->getDiscoverMedia($genreId, $page);

        return view('genreTvShows/index', [
            'name' => $genre,
            'tvShows' => $tvShows['results']
        ]);
    }

    public function openSpecificTvShow(Request $request, Int $mediaId)
    {
        $getApiData = new GetApiData(self::MEDIA_TYPE);

        $reviewDetails = Review::where('media_id', $mediaId)->where('media_type', self::MEDIA_TYPE)->first();

        if ($reviewDetails === null){
            $mediaUserController = new MediaUserController;
            $reviewDetails = $mediaUserController->createReview($mediaId, self::MEDIA_TYPE);
        }

        $comments = UserComment::where('review_id', $reviewDetails->id)->get();

        $replies = UserReply::join('user_comments', 'user_replys.user_comment_id', '=', 'user_comments.id')
            ->where('user_comments.review_id', $reviewDetails->id)->get();

        $mediaUser = null;
        $episodesUsers = [];
        $inWatchlist = false;
        if (!Auth::guest()){
            $mediaUser = MediaUser::where('media_id', $mediaId)->where('user_id', Auth::user()->id)
                ->where('media_type', self::MEDIA_TYPE)->first();
            if ($mediaUser === null){
                $mediaUserController = new MediaUserController;
                $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $mediaId, self::MEDIA_TYPE,new DateTime);
            }
            $userWatchlist = TVWatchlist::join('watchlists', 'tv_watchlists.watchlist_id', 'watchlists.id')
                ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
                ->join('media_users', 'watchlists.media_user_id', 'media_users.id')->where('list_types.user_id', Auth::user()->id)->where('media_users.id', $mediaUser->id)->first();
            if($userWatchlist !== null){
                $inWatchlist = true;
            }
            $episodesUser = EpisodeUser::where('media_users.id', $mediaUser->id)->get();
            foreach($episodesUser as $episodeUser) {
                $episodesUsers[$episodeUser->episode_id] = $episodeUser;
            }
        }


        $availability = $getApiData->getWatchProvider((string)$mediaId);

        $tvShow = $getApiData->getMediaData((string)$mediaId);
        $seasons = [];
        foreach($tvShow['seasons'] as $season){
            $seasons[$season['season_number']] = $getApiData->getSeasonData((string)$mediaId, (string)$season['season_number']);
        }


        return view('specificTvShow/index', [
            'comments' => $comments,
            'replies' => $replies,
            'reviewDetails' => $reviewDetails,
            'seasons' => $seasons['episodes'],
            'availability' => $availability['results'],
            'mediaUser' => $mediaUser,
            'episodeUser' => $episodesUsers,
            'tvShow' => $tvShow,
            'inWatchlist' => $inWatchlist,
        ]);


    }
}
