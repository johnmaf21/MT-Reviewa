<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ListTypeController;
use App\Models\GetApiData;
use App\Models\UserComment;
use App\Models\UserReply;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\MediaUser;
use App\Models\EpisodeUser;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;


class SpecificTvShowController extends Controller
{
    const MEDIA_TYPE = 'tv';

    public function updateLike(Request $request, MediaUser $mediaUser, Int $mediaId){
        $request->validate([
            'hasLiked' => 'required',
        ]);
        if ($mediaUser === null){
            $mediaUserController = new MediaUserController;
            $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $mediaId, self::MEDIA_TYPE,new DateTime);
        }

        $commentsController = new CommentsController;
        $commentsController->updateLike($request->hasLiked, $mediaUser);

        return back()->with('success', 'user like updated');
    }

    public function hasWatched(Request $request, MediaUser $mediaUser, Int $mediaId){
        $request->validate([
            'isCompleted' => 'required',
        ]);
        if ($mediaUser === null){
            $listTypeController = new ListTypeController;
            $mediaUser = $listTypeController->addToTvWatchlist($mediaId, Auth::user());
        }
        $mediaUserController = new MediaUserController;
        $mediaUser->is_completed = $request->isCompleted;
        $mediaUser->completion = $mediaUserController->calcTvShowCompletion($mediaUser->id);
        $mediaUser->save();

        return back()->with('success', 'hasWatched updated');
    }

    public function removeComment(Request $request, UserComment $userComment){
        $commentsController = new CommentsController;
        $commentsController->removeComment($userComment);

        return back()->with('success', 'Comment deleted successfully');
    }

    public function postComment(Request $request, Review $review){
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


    public function hasWatchedEpisode(Request $request, MediaUser $mediaUser, Int $mediaId, Int $episodeId, Int $season, Int $episode, Boolean $hasWatched){

        $mediaUserController = new MediaUserController();
        if ($mediaUser === null){
            $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $mediaId, self::MEDIA_TYPE, new DateTime);
        }
        $episodeUser = EpisodeUser::where('media_user_id', $mediaUser->id)->where('episode_id', $episodeId)->first();
        if ($episodeUser === null){
            $episodeUser = $mediaUserController->createEpisodeUser($mediaId, $mediaUser, $season, $episode);
        }
        $mediaUserController->updateEpisodeUser($episodeUser, $hasWatched);
        $mediaUserController->updateCurrentEpisode($mediaUser);
        $mediaUser->completion = $mediaUserController->calcTvShowCompletion($mediaUser);
        $mediaUser->save();
    }

    public function hasWatchedEpisodes(Request $request, MediaUser $mediaUser, Int $mediaId, Int $episodeId, Int $season, Int $episode, Boolean $hasWatched, Boolean $checkRest){
        $mediaUserController = new MediaUserController();
        if ($mediaUser === null){
            $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $mediaId, self::MEDIA_TYPE, new DateTime);
        }
        $episodeUser = EpisodeUser::where('media_user_id', $mediaUser->id)->where('episode_id', $episodeId)->first();
        if ($episodeUser === null){
            $episodesUser = array($mediaUserController->createEpisodeUser($mediaId, $mediaUser, $season, $episode));
        }
        if ($checkRest){
            if ($hasWatched){
            $episodesUser = $mediaUserController->createPreviousEpisodeUsers($mediaUser,$season,$episode);
            } else {
                $episodesUser = $mediaUserController->createFutureEpisodeUsers($mediaUser,$season,$episode);
            }
        }

        foreach ($episodesUser as $episodeUser){
            $mediaUserController->updateEpisodeUser($episodeUser, $hasWatched);
        }

        $mediaUserController->updateCurrentEpisode($mediaUser);
        $mediaUser->completion = $mediaUserController->calcTvShowCompletion($mediaUser);
        $mediaUser->save();
    }

    public function openSpecificEpisode(Request $request, $episode, $tvShow){
        $getApiData = new GetApiData(self::MEDIA_TYPE);

        $reviewDetails = Review::where('media_id', $episode['id'])->where('media_type', 'episode')->first();
        if ($reviewDetails === null){
            $mediaUserController = new MediaUserController;
            $reviewDetails = $mediaUserController->createReview($episode['id'], "episode");
        }

        $comments = UserComment::where('review_id', $reviewDetails->id)->get();

        $replies = UserReply::join('user_comments', 'user_replys.user_comment_id', '=', 'user_comments.id')
                            ::where('user_comments.review_id', $reviewDetails->id)->get();

        $mediaUser = MediaUser::where('media_id', $tvShow['id'])->where('user_id', Auth::user()->id)
            ->where('media_type', self::MEDIA_TYPE)->first();
        if ($mediaUser === null){
            $mediaUserController = new MediaUserController;
            $mediaUser = $mediaUserController->createMediaUser(Auth::user(), $tvShow['id'], self::MEDIA_TYPE,new DateTime);
        }

        $episodeUser = EpisodeUser::where('media_users.id', $mediaUser->id)
                                    ->where('episode_id', $episode['id'])->first();
        if ($episodeUser === null){
            $mediaUserController = new MediaUserController;
            $episodeUser = $mediaUserController->createEpisodeUser($episode['id'], $mediaUser, $episode['season_number'], $episode['episode_number']);
        }

        $availability = $getApiData->getWatchProvider((string)$tvShow['id']);

        $episode = $getApiData->getEpisodeData((string)$tvShow['id'], (string)$episode['season_number'], (string)$episode['episode_number']);

        return view('specificTvShow/index', [
            'comments' => $comments,
            'replies' => $replies,
            'reviewDetails' => $reviewDetails,
            'episode' => $episode,
            'tvShow' => $tvShow,
            'availability' => $availability['results'],
            'mediaUser' => $mediaUser,
            'episodeUser' => $episodeUser,
        ]);

    }
}
