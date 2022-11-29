<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\MoviesController;
use App\Models\MediaUser;
use App\Models\Review;
use App\Models\UserComment;
use App\Models\UserReply;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class SpecificMovieController extends Controller
{
    public function updateLike(Request $request, Int $media_id, MediaUser $mediaUser, $hasLiked){

        if ($mediaUser === null){
            $mediaUserController = new MediaUserController;
            $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $media_id, "movie",new DateTime);
        }

        $commentsController = new CommentsController;
        $commentsController->updateLike($hasLiked, $mediaUser);

        return back()->with('success', 'user like updated');
    }

    public function hasWatched(Int $media_id, MediaUser $mediaUser,$hasWatched){

        if ($mediaUser === null){
            $listTypeController = new ListTypeController;
            $mediaUser = $listTypeController->addToMovieWatchlist($media_id, Auth::user());
        }

        $mediaUser->is_completed = filter_var($hasWatched, FILTER_VALIDATE_BOOLEAN);
        if($hasWatched){$mediaUser->completion = 100;}
        $mediaUser->save();
        //dd($mediaUser);

        return back()->with('success', 'hasWatched updated');
    }


    public function removeComment(Request $request, UserComment $userComment){
        $commentsController = new CommentsController;
        $commentsController->removeComment($userComment);

        return back()->with('success', 'Comment deleted successfully');
    }

    public function postComment(Request $request, Int $mediaId, Review $review){
        $request->validate([
            'comment' => 'required',
        ]);
        $commentsController = new CommentsController;
        $commentsController->postComment(Auth::user(), $review, $request->comment);

        return back()->with('success', 'Comment posted successfully');
    }

    public function removeReply(Request $request, UserReply $userReply){
        $commentsController = new CommentsController;
        $commentsController->removeReply($userReply);
        return back()->with('success', 'Reply deleted successfully');
    }

    public function postReply(Request $request, UserComment $userComment){
        $request->validate([
            'comment' => 'required',
        ]);

        $commentsController = new CommentsController;
        $commentsController->postReply($userComment, Auth::user());

        return back()->with('success', 'Comment posted successfully');
    }



}
