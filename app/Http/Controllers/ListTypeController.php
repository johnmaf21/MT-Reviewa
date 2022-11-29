<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MediaUserController;
use App\Models\ListType;
use App\Models\MediaUser;
use Illuminate\Http\Request;
use App\Models\Watchlist;
use App\Models\MovieWatchlist;
use App\Models\TVWatchlist;
use App\Models\User;
use DateTime;
use Ramsey\Uuid\Type\Integer;

class ListTypeController extends Controller
{
    public function addToMovieWatchlist(Int $mediaId, User $user)
    {
       $dateStarted = new DateTime;
       $userWatchlist = MovieWatchlist::join('watchlists', 'movie_watchlists.watchlist_id', 'watchlists.id')
                            ->join('list_types', 'watchlists.list_type_id', 'list_types.id')->where('list_types.user_id',$user->id)->first();

       $mediaUser = MediaUser::where('media_id',$mediaId)
                               ->where('media_type','movie')
                               ->where('user_id',$user->id)->first();

       if ($userWatchlist === null) {
            $listType = $this->createListType($dateStarted, $user, "Your Movie Watchlist");
       } else $listType = $userWatchlist->watchlist->listType;

        if ($mediaUser===null) {
            $mediaUserController = new MediaUserController;
            $mediaUser = $mediaUserController->createMediaUser($user, $mediaId, "movie", $dateStarted);
        }

       $watchlist = $this->createWatchlist($listType, $mediaUser);
       $movieWatchlist = new MovieWatchlist;
       $movieWatchlist->watchlist()->associate($watchlist);
       $movieWatchlist->save();

       return $mediaUser;
    }

    public function createListType(DateTime $dateStarted, User $user, String $listName)
    {
        $listType = new ListType;
        $listType->name = $listName;
        $listType->date_created = $dateStarted;
        $listType->date_updated = $dateStarted;
        $listType->user()->associate($user);
        $listType->save();

        return $listType;
    }

    public function createWatchlist(ListType $listType, MediaUser $mediaUser)
    {
        $watchlist = new Watchlist;
        $watchlist->listType()->associate($listType);
        $watchlist->mediaUser()->associate($mediaUser);
        $watchlist->save();
        return $watchlist;
    }

    public function addToTvWatchlist(Int $tvShowId, User $user){
       $dateStarted = new DateTime;
       $userWatchlist = TVWatchlist::join('watchlists', 'tv_watchlists.watchlist_id', 'watchlists.id')
                            ->join('list_types', 'watchlists.list_type_id', 'list_types.id')->where('list_types.user_id', '=', $user->id)->first();

       $mediaUser = MediaUser::where('media_id',$tvShowId)
                               ->where('user_id', $user->id)
                               ->where('media_type', 'tv')->first();


       if ($userWatchlist === null) {
            $listType = $this->createListType($dateStarted, $user, "Your TV Show Watchlist");

       } else $listType = $userWatchlist->watchlist->listType;

        if ($mediaUser===null) {
            $mediaUserController = new MediaUserController;
            $mediaUser = $mediaUserController->createMediaUser($user,$tvShowId, 'tv',$dateStarted);
        }

       $watchlist = $this->createWatchlist($listType, $mediaUser);
       $tvWatchlist = new TVWatchlist;
       $tvWatchlist->watchlist()->associate($watchlist);
       $tvWatchlist->save();

       return $mediaUser;
    }

    public function removeFromMovieWatchlist(String $mediaId, User $user){

        $mediaUser = MediaUser::where('media_id', '=', $mediaId)
            ->where('user_id', '=', $user->id)
            ->where('media_type', '=', 'movie')->first();

        $userWatchlist = MovieWatchlist::join('watchlists', 'movie_watchlists.watchlist_id', 'watchlists.id')
                                    ->join('list_types', 'watchlists.list_type_id', 'list_types.id')->where('list_types.user_id', $user->id)
                                    ->where('watchlists.media_user_id',$mediaUser->id)->first();

        $userWatchlist->watchlist->delete();
        $userWatchlist->delete();

    }

    public function removeFromTvWatchlist(Int $tvShowId, User $user){

        $mediaUser = MediaUser::where('media_id', '=', $tvShowId)
            ->where('user_id', '=', $user->id)
            ->where('media_type', '=', 'tv')->first();

        $userWatchlist = TVWatchlist::join('watchlists', 'tv_watchlists.watchlist_id', 'watchlists.id')
                                    ->join('list_types', 'watchlists.list_type_id', 'list_types.id')->where('list_types.user_id', $user->id)
                                    ->where('watchlists.media_user_id',$mediaUser->id)->first();

        $userWatchlist->watchlist->delete();
        $userWatchlist->delete();

        $mediaUser->delete();
    }

}
