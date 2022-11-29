@extends('layouts.app3')

@section('content')
    <div class="next">
        <h1 class="specific__title">{{$movie['title']}}</h1>
        <p>{{$movie['release_date']."  .  ".date('h:i ', mktime(0,$movie['runtime']))."  .  ".(string)($movie['vote_average']*10).'%'}}</p>
        <p style="font-weight: lighter;">{{$movie['overview']}}</p>
        <div class="genres">
            @foreach($movie['genres'] as $genre)
                <a href="{{ route('seeAll.getNewPage', ['genre', 'movie', 1, $genre['name'], $genre['id'], 1]) }}">{{$genre['name']}}</a>
            @endforeach
        </div>
        <div class="socials">
            @if($movie['homepage'] !== null)
                <a href="{{$movie['homepage']}}"><img src="{{ asset("images/web.png") }}" alt="{{$movie['title']." webpage"}}"></a>
            @endif
            @if($movie['external_ids']['twitter_id'] !== null)
                <a href="{{"https://twitter.com/".$movie['external_ids']['twitter_id']}}"><img src="{{ asset("images/twitter.png") }}" alt="{{$movie['title']." twitter account"}}"></a>
            @endif
            @if($movie['external_ids']['instagram_id'] !== null)
                <a href="{{"https://www.instagram.com/".$movie['external_ids']['instagram_id']}}"><img src="{{ asset("images/instagram.png") }}" alt="{{$movie['title']." instagram account"}}"></a>
            @endif
            @if($movie['external_ids']['facebook_id'] !== null)
                <a href="{{"https://en-gb.facebook.com/".$movie['external_ids']['facebook_id']}}"><img src="{{ asset("images/facebook.png") }}" alt="{{$movie['title']." facebook account"}}"></a>
            @endif
        </div>
        @if(!Auth::guest())
            @if($inWatchlist)
                @if(!$mediaUser->is_completed)
                    <p style="font-weight: lighter;">Watched?: <a href="{{ route('movie.hasWatched', [$movie['id'], $mediaUser, 1]) }}"><img src="{{ asset('images/greyCheck.png') }}" width="30px"></a></p>
                    <a class="in-watchlist" href="{{ route('movie.removeFromWatchlist', $movie['id']) }}">Remove</a>
                @else
                    <a href="{{ route('movie.hasWatched', [$movie['id'], $mediaUser, 0]) }}"><img src="{{ asset('images/greenCheck.png') }}" width="30px"></a>
                @endif
            @else
                <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
            @endif
        @else
            <p style="font-weight: lighter;"><a href="/register">Create an account</a> or <a href="/login">sign in</a> to add movies to your watchlist</p>
        @endif
    </div>


    <div class="backdrop">
        <img src="{{ "https://image.tmdb.org/t/p/original".$movie['backdrop_path'] }}" alt="{{$movie['title']." backdrop"}}">
    </div>

    <div class="comments">
        @if(!Auth::guest())
            @if(empty($comments))
                <p>Share your thoughts. Be the first to comment</p>
            @endif
            <div class="curr-user-comment">
                <form method="POST" action="{{ route('movie.postComment', [$movie['id'],$reviewDetails]) }}">
                @csrf
                    <img src="{{Auth::user()->profile_pic}}">
                    <div class="comment-entry">
                        <textarea id="comment" name="comment" placeholder=" Share your thoughts"> </textarea>
                    </div>

                    <button type="submit" class="post-button">
                        Post
                    </button>
                </form>
            </div>
        @else
            <p style="font-weight: lighter;"><a href="/register">Create an account</a> or <a href="/login">sign in</a> to share your own thoughts on {{$movie['title']}}</p>
        @endif
        @foreach($comments as $comment)
                <div class="user-comment">
                    <div class="user-head">
                        <img src="{{$comment->user->profile_pic}}">
                        <p>{{ $comment->user->username }}</p>
                        <p>{{ $comment->date_posted }}</p>
                    </div>
                    <p class="actual-comment">{{ $comment->comment }}</p>

                </div>
            @endforeach
    </div>

    <div class="availabilty">

    </div>

    <div class="cast">
        <h2>Cast</h2>
        <div class="cast-group">
        @for($x=0; $x<20; $x++)
            @if(array_key_exists($x,$movie['credits']['cast']))
                <div class="cast-member">
                    @if($movie['credits']['cast'][$x]['profile_path'] === null)
                        <img src="{{ asset('images/profile_placeholder.png') }}">
                    @else
                        <img src="{{ "https://image.tmdb.org/t/p/w185".$movie['credits']['cast'][$x]['profile_path'] }}">
                    @endif
                    <p class="cast-name">{{ $movie['credits']['cast'][$x]['name'] }}</p>
                    <p class="cast-character">{{ $movie['credits']['cast'][$x]['character'] }}</p>
                </div>
            @endif
        @endfor
        </div>
    </div>
@endsection

