<?php

namespace App\Http\Controllers;

use App\Models\EpisodeUser;
use App\Models\MediaUser;
use App\Models\Review;
use App\Models\User;
use App\Models\UserComment;
use App\Models\UserLike;
use App\Models\UserReply;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class CommentsController extends Controller
{
    public function removeComment(UserComment $userComment){
        UserReply::where('user_comment_id',$userComment->id)->delete();
        UserLike::where('user_comment_id',$userComment->id)->delete();
        $userComment->delete();

    }

    public function removeReply(UserReply $userReply){
        $userReply->delete();
    }

    public function postReply(UserComment $userComment, User $user){
        $userReply = new UserReply;
        $userReply->user()->associate($user);
        $userReply->originalComment()->associate($userComment);
        $userReply->save();
    }
    public function postComment(User $user, Review $review, String $comment){
        $userComment = new UserComment;
        $userComment->user()->associate($user);
        $userComment->review()->associate($review);
        $userComment->comment = $comment;
        $userComment->date_posted = new DateTime;
        $userComment->save();
    }

    public function updateCommentLike(Boolean $hasLiked, UserComment $userComment, User $user){
        $userLike = UserLike::where('user_comment_id',$userComment->id)->where('user_id', '=', $user->id)->first();

        if ($userLike === null){
            if ($hasLiked){
                $userLike = new UserLike;
                $userLike->userComment()->associate($userComment);
                $userLike->user()->associate(Auth::user());
                $userLike->save();
            }
        }
        else if (!$hasLiked){
            $userLike->delete();
        }
    }

    public function updateEpisodeLike(Boolean $hasLiked, EpisodeUser $episodeUser){
        $episodeUser->has_liked = $hasLiked;
        $episodeUser->save();
    }

    public function updateLike(Boolean $hasLiked, MediaUser $mediaUser){
        $mediaUser->has_liked = $hasLiked;
        $mediaUser->save();
    }
}
