@extends('layouts.app2')

@section('content')
    <div class="title">
        <h1>Tv Shows</h1>
    </div>
    @if(Auth::guest())
        <div class="intro__text">
            <p><a href="/register">Create an account</a> or <a href="/login">sign in</a> to add movies to your watchlist</p>
        </div>
    @endif

    @if(!empty($watchlist))
        <div class="media-options">
            <div class="media-type">
                <h2>Your Watchlist</h2>
                <a href="/profile">See in profile</a>
            </div>
            <div class="media-container">
                @foreach($watchlist as $tvShow)
                    <div class="media">
                        @if(!Auth::guest())
                            @if(!empty($watchlist))
                                @if(array_key_exists($tvShow['id'],$watchlist))
                                    <a class="in-watchlist" href="{{ route('tvShow.removeFromWatchlist', $tvShow['id']) }}">Remove</a>
                                @else
                                    <a class="out-watchlist" href="{{ route('tvShow.addToWatchlist', $tvShow['id']) }}">Add</a>
                                @endif
                            @elseif(!array_key_exists($tvShow['id'],$completed))
                                <a class="out-watchlist" href="{{ route('tvShow.addToWatchlist', $tvShow['id']) }}">Add</a>
                            @else
                                <a class="out-watchlist" href="">Completed</a>
                            @endif
                        @endif
                            <a class="media-links" href="{{ "/tvShows/".$tvShow['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$tvShow['poster_path']}}" alt="poster"></a>
                            <a class="media-links" href="{{ "/tvShows/".$tvShow['id'] }}">{{$tvShow['name']}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @foreach($tvShows as $tvShowType => $tvShowTypeOptions)
        @if(!empty($tvShowTypeOptions))
            <div class="media-options">
                <div class="media-type">
                    <h2>{{$tvShowType}}</h2>
                    <a href="{{ route('tvShow.displaySeeAll', [$tvShowType, 'null', 0]) }}">See more</a>
                </div>
                <div class="media-container">
                    @foreach($tvShowTypeOptions as $tvShow)
                        <div class="media">
                            @if(!Auth::guest())
                                @if(!empty($watchlist))
                                    @if(array_key_exists($tvShow['id'],$watchlist))
                                        <a class="in-watchlist" href="{{ route('tvShow.removeFromWatchlist', $tvShow['id']) }}">Remove</a>
                                    @else
                                        <a class="out-watchlist" href="{{ route('tvShow.addToWatchlist', $tvShow['id']) }}">Add</a>
                                    @endif
                                @elseif(!array_key_exists($tvShow['id'],$completed))
                                    <a class="out-watchlist" href="{{ route('tvShow.addToWatchlist', $tvShow['id']) }}">Add</a>
                                @else
                                    <a class="out-watchlist" href="">Completed</a>
                                @endif
                            @endif
                            <a class="media-links" href="{{ "/tvShows/".$tvShow['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$tvShow['poster_path']}}" alt="poster"></a>
                            <a class="media-links" href="{{ "/tvShows/".$tvShow['id'] }}">{{$tvShow['name']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    @foreach($genres as $genre => $tvShows)
        @if(!empty($tvShows['$tvShows']))
            <div class="media-options">
                <div class="media-type">
                    <h2>{{$genre}}</h2>
                    <a href="{{ route('tvShow.displaySeeAll', ['genre', $genre, $tvShows['genre_id']]) }}">See more</a>
                </div>
                <div class="media-container">
                    @foreach($tvShows['tvShows'] as $tvShow)
                        <div class="media">
                            @if(!Auth::guest())
                                @if(!empty($watchlist))
                                    @if(array_key_exists($tvShow['id'],$watchlist))
                                        <a class="in-watchlist" href="{{ route('tvShow.removeFromWatchlist', $tvShow['id']) }}">Remove</a>
                                    @else
                                        <a class="out-watchlist" href="{{ route('tvShow.addToWatchlist', $tvShow['id']) }}">Add</a>
                                    @endif
                                @elseif(!array_key_exists($tvShow['id'],$completed))
                                    <a class="out-watchlist" href="{{ route('tvShow.addToWatchlist', $tvShow['id']) }}">Add</a>
                                @else
                                    <a class="out-watchlist" href="">Completed</a>
                                @endif
                            @endif
                            <a class="media-links" href="{{ "/tvShows/".$tvShow['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$tvShow['poster_path']}}" alt="poster"></a>
                            <a class="media-links" href="{{ "/tvShows/".$tvShow['id'] }}">{{$tvShow['name']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach


@endsection

