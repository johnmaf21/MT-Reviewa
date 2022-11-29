<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommentsController;
use App\Models\GetApiData;
use App\Models\MediaUser;
use App\Models\MovieWatchlist;
use App\Models\TVWatchlist;
use App\Models\User;
use App\Models\UserComment;
use App\Models\UserLike;
use App\Models\UserReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updatePrivacy(Request $request, User $user){
        $request->validate([
            'isPrivate' => 'required',
        ]);

        $user->is_private = $request->isPrivate;
        $user->save();
    }

    public function removeFromMovieWatchlist(Request $request, Int $mediaId){
        $listTypeController = new ListTypeController;
        $listTypeController->removeFromMovieWatchlist($mediaId, Auth::user());
    }

    public function removeFromTvWatchlist(Request $request, Int $mediaId){
        $listTypeController = new ListTypeController;
        $listTypeController->removeFromTvWatchlist($mediaId, Auth::user());
    }

    public function updateLike(Request $request, MediaUser $mediaUser){
        $request->validate([
            'hasLiked' => 'required',
        ]);

        $commentsController = new CommentsController;
        $commentsController->updateLike($request->hasLiked, $mediaUser);

    }

    public function updateCommentLike(Request $request, UserComment $userComment){
        $request->validate([
            'hasLiked' => 'required',
        ]);

        $commentsController = new CommentsController;
        $commentsController->updateCommentLike($request->hasLiked, $userComment, Auth::user());

        return back()->with([
            'success','Updated Liked comment.']);

    }

    public function removeComment(Request $request, UserComment $userComment){
        $commentsController = new CommentsController;
        $commentsController->removeComment($userComment);

        return back()->with('success', 'Comment deleted successfully');

    }

    public function removeReply(Request $request, UserReply $userReply){
        $commentsController = new CommentsController;
        $commentsController->removeReply($userReply);

        return back()->with('success', 'Comment deleted successfully');
    }

    public function displayWatchlist(){
        $getApiData = new GetApiData("movie");

        $movieWatchlist = [];
        $userWatchlist = MovieWatchlist::join('watchlists', 'movie_watchlists.watchlist_id', 'watchlists.id')
            ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
            ->join('media_users', 'watchlists.media_user_id', 'media_users.id')::where('list_types.user_id', Auth::user()->id)->where('media_users.is_completed', false)->get();
        foreach($userWatchlist as $tvShow){
            $movieWatchlist[] = $getApiData->getMediaData($tvShow->media_id);
        }

        $getApiData->mediaType = "tv";
        $tvWatchlist = [];
        $userWatchlist = TVWatchlist::join('watchlists', 'tv_watchlists.watchlist_id', 'watchlists.id')
            ->join('list_types', 'watchlists.list_type_id', 'list_types.id')
            ->join('media_users', 'watchlists.media_user_id', 'media_users.id')::where('list_types.user_id', Auth::user()->id)->where('media_users.is_completed', false)->get();
        foreach($userWatchlist as $tvShow){
            $tvWatchlist[] = $getApiData->getMediaData($tvShow->media_id);
        }

        return view('profile.watchlist', [
                    'movieWatchlist' => $movieWatchlist,
                    'tvWatchlist' => $tvWatchlist
                ]);
    }

    public function displayComments(){
        $userComments = UserComment::where('user_id', Auth::user())->get();

        return view('profile.comments', [
            'userComments' => $userComments
        ]);
    }

    public function displayReplies(){
        $userReplies = UserReply::where('user_id', Auth::user())->get();

        return view('profile.replies', [
                    'userReplies' => $userReplies
                ]);
    }

    public function displayLikes(){
        $userLikes = UserLike::where('user_like.user_id', Auth::user()->id);

        return view('profile.replies', [
            'userLikes' => $userLikes
        ]);
    }

    public function index(){

        return $this->displayWatchlist();

    }

}
