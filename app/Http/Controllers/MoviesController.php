<?php

namespace App\Http\Controllers;

use App\Models\MediaUser;


use App\Models\GetApiData;
use App\Models\MovieWatchlist;
use App\Models\Review;
use App\Models\UserComment;
use App\Models\UserReply;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ListTypeController;
use Jorenvh\Share\Share;
use Jorenvh\Share\ShareFacade;

class MoviesController extends Controller
{
    const MEDIA_TYPE = "movie";

    public function index(){
        // Display all the movies per genre
        $getApiData = new GetApiData(self::MEDIA_TYPE);

        $trending = $getApiData->getTrendingData((string)1);
        $topRated = $getApiData->getTopRatedData((string)1);
        $popular = $getApiData->getPopularData((string)1);
        $inTheatres = $getApiData->getInTheatresData((string)1);
        $upcoming = $getApiData->getUpcomingData((string)1);

        $genreMovies = [];
        $genres = $getApiData->getGenres();
        foreach($genres['genres'] as $genre){
            $genreMovies[$genre['name']]['movies'] = $getApiData->getDiscoverMedia((string)$genre['id'], (string)1)['results'];
            $genreMovies[$genre['name']]['genre_id'] = $genre['id'];

        }

        $watchlist = [];
        $mediaUsers = [];
        $completed = [];
        if(!Auth::guest()){
            $userWatchlist = MovieWatchlist::join('watchlists', 'movie_watchlists.watchlist_id', 'watchlists.id')
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

        return view('movies/index', [
                   'watchlist' => $watchlist,
                   'movies' => ['In Theatres' => $inTheatres['results'],
                               'Upcoming' => $upcoming['results'],
                               'Trending' => $trending['results'],
                               'Top Rated' => $topRated['results'],
                               'Popular' => $popular['results'],
                       ],
                   'genres' => $genreMovies,
                    'mediaUsers' => $mediaUsers,
                    'completed' => $completed
                ]);
    }

    public function addToWatchlist(Request $request, Int $mediaId){
        $listTypeController = new ListTypeController;
        $listTypeController->addToMovieWatchlist($mediaId, Auth::user());
        return back()->with("Added to watchlist");

    }

    public function displaySeeAll(String $type, String $typeQuery='', Int $id=0){
        $mediaUsers = [];
        $results = [];
        if($type !== 'genre') {
            $typeQuery = $type;
        }

        $getApiData = new GetApiData(self::MEDIA_TYPE);
        if(!Auth::guest()){
            $mediaUser =  MediaUser::where('user_id',Auth::user()->id)->where('media_type',self::MEDIA_TYPE)->get();
            foreach($mediaUser as $media) {
                $mediaUsers[$media->media_id] = $media;
                if($type === "completed"){
                    if($media->is_completed) {
                        $completed[$media->media_id] = $getApiData->getMediaData((string)$media->media_id);
                    }
                }
            }
        }

        if($type !== "completed"){
            if($type === "watchlist"){
                $userWatchlist = MovieWatchlist::join('watchlists', 'movie_watchlists.watchlist_id', 'watchlists.id')
                    ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
                    ->join('media_users', 'watchlists.media_user_id', 'media_users.id')->where('list_types.user_id', Auth::user()->id)->where('media_users.is_completed', false)->get();
                $count=0;
                foreach($userWatchlist as $media){
                    $watchlist[$count] = $getApiData->getMediaData((string)$media->media_id);
                    $count++;
                }
                $results = $watchlist;
            } elseif ($type === "genre") {
                $results = $getApiData->getDiscoverMedia((string)$id, (string)1)['results'];
            } else {
                $getData = [
                    'In Theatres' => $getApiData->getInTheatresData((string)1)['results'],
                    'Upcoming' => $getApiData->getUpcomingData((string)1)['results'],
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

    public function removeFromWatchlist(Request $request, Int $mediaId)
    {
        $listTypeController = new ListTypeController;
        $listTypeController->removeFromMovieWatchlist($mediaId, Auth::user());
        return back()->with("Removed from watchlist");
    }

    public function openSpecificMovie(Request $request, Int $mediaId){
        $getApiData = new GetApiData(self::MEDIA_TYPE);

        $reviewDetails = Review::where('media_id', $mediaId)
                                 ->where('media_type', self::MEDIA_TYPE)->first();

        if ($reviewDetails === null){
            $mediaUserController = new MediaUserController;
            $reviewDetails = $mediaUserController->createReview($mediaId, self::MEDIA_TYPE);
        }

        $comments = UserComment::where('review_id',$reviewDetails->id)->get();

        $replies = UserReply::join('user_comments', 'user_replys.user_comment_id', '=', 'user_comments.id')
            ->where('user_comments.review_id', $reviewDetails->id)->get();

        $commentReplies = [];
        if(!empty($replies)){
            foreach($replies as $reply){
                $commentReplies[$reply->user_comment_id] = $reply;
        }}


        $mediaUser = null;
        $inWatchlist = false;
        if(!Auth::guest()){
            $mediaUser = MediaUser::where('media_id', $mediaId)->where('user_id', Auth::user()->id)->first();
            if ($mediaUser === null){
                $mediaUserController = new MediaUserController;
                $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $mediaId, self::MEDIA_TYPE,new DateTime);
            }
            $userWatchlist = MovieWatchlist::join('watchlists', 'movie_watchlists.watchlist_id', 'watchlists.id')
                ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
                ->join('media_users', 'watchlists.media_user_id', 'media_users.id')->where('list_types.user_id', Auth::user()->id)->where('media_users.id', $mediaUser->id)->first();
            if($userWatchlist !== null){
                $inWatchlist = true;
            }
        }

        $availability = $getApiData->getWatchProvider((string)$mediaId);

        $movie = $getApiData->getMediaData((string)$mediaId);

        $similarMovies = $getApiData->getSimilarMediaData((string)$mediaId);

        return view('specificMovie/index', [
            'comments' => $comments,
            'replies' => $commentReplies,
            'reviewDetails' => $reviewDetails,
            'availability' => $availability['results'],
            'similarMovies' => $similarMovies['results'],
            'mediaUser' => $mediaUser,
            'movie' => $movie,
            'inWatchlist' => $inWatchlist,
        ]);
    }

}
