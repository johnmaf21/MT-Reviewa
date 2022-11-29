<?php

namespace App\Http\Controllers;

use App\Models\EpisodeUser;
use App\Models\MediaUser;
use App\Models\Review;
use App\Models\UserComment;
use App\Models\UserReply;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecificEpisodeController extends Controller
{

    public function hasWatchedEpisode(Request $request, MediaUser $mediaUser, Int $mediaId, Int $episodeId, Int $season, Int $episode){
        $request->validate([
            'hasWatched' => 'required',
        ]);
        $mediaUserController = new MediaUserController();
        if ($mediaUser === null){
            $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $mediaId, 'tv', new DateTime);
        }
        $episodeUser = EpisodeUser::where('media_user_id', $mediaUser->id)->where('episode_id', $episodeId)->first();
        if ($episodeUser === null){
            $episodeUser = $mediaUserController->createEpisodeUser($mediaId, $mediaUser, $season, $episode);
        }
        $mediaUserController->updateEpisodeUser($episodeUser, $request->hasWatched);
        $mediaUser->completion = $mediaUserController->calcTvShowCompletion($mediaUser);
        $mediaUser->save();
    }

    public function postComment(Request $request, Review $review){
        $request->validate([
            'comment' => 'required',
        ]);
        $commentsController = new CommentsController;
        $commentsController->postComment(Auth::user(), $review, $request->comment);

        return back()->with('success', 'Comment posted successfully');
    }

    public function removeComment(Request $request, UserComment $userComment){
        $commentsController = new CommentsController;
        $commentsController->removeComment($userComment);

        return back()->with('success', 'Comment deleted successfully');
    }

    public function updateEpisodeLike(Request $request, MediaUser $mediaUser, Int $episodeId){
        $request->validate([
            'hasLiked' => 'required',
        ]);
        $episodeUser = EpisodeUser::where('media_user_id', $mediaUser->id)->where('episode_id', $episodeId)->first();

        $commentsController = new CommentsController;
        $commentsController->updateEpisodeLike($request->hasLiked, $episodeUser);

        return back()->with('success', 'user like updated');
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
