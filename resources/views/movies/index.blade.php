@extends('layouts.app2')

@section('content')
    <div class="title">
        <h1>Movies</h1>
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
                @foreach($watchlist as $movie)
                    <div class="media">
                        @if(!Auth::guest())
                            @if(!empty($watchlist))
                                @if(array_key_exists($movie['id'],$watchlist))
                                    <a class="in-watchlist" href="{{ route('movie.removeFromWatchlist', $movie['id']) }}">Remove</a>
                                @else
                                    <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
                                @endif
                            @elseif(!array_key_exists($movie['id'],$completed))
                                <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
                            @else
                                <a class="out-watchlist" href="">Completed</a>
                            @endif
                        @endif
                        <a class="media-links" href="{{ "/movies/".$movie['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$movie['poster_path']}}" alt="poster"></a>
                        <a class="media-links" href="{{ "/movies/".$movie['id'] }}">{{$movie['title']}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @foreach($movies as $movieType => $movieTypeOptions)
        @if(!empty($movieTypeOptions))
            <div class="media-options">
                <div class="media-type">
                    <h2>{{$movieType}}</h2>
                    <a href="{{ route('movie.displaySeeAll', [$movieType, 'null', 0]) }}">See more</a>
                </div>
                <div class="media-container">
                    @foreach($movieTypeOptions as $movie)
                        <div class="media">
                            @if(!Auth::guest())
                                @if(!empty($watchlist))
                                    @if(array_key_exists($movie['id'],$watchlist))
                                        <a class="in-watchlist" href="{{ route('movie.removeFromWatchlist', $movie['id']) }}">Remove</a>
                                    @else
                                        <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
                                    @endif
                                @elseif(!array_key_exists($movie['id'],$completed))
                                    <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
                                @else
                                    <a class="out-watchlist" href="">Completed</a>
                                @endif
                            @endif
                            <a class="media-links" href="{{ "/movies/".$movie['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$movie['poster_path']}}" alt="poster"></a>
                            <a class="media-links" href="{{ "/movies/".$movie['id'] }}">{{$movie['title']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    @foreach($genres as $genre => $movies)
        @if(!empty($movies['movies']))
            <div class="media-options">
                <div class="media-type">
                    <h2>{{$genre}}</h2>
                    <a href="{{ route('movie.displaySeeAll', ['genre', $genre, $movies['genre_id']]) }}">See more</a>
                </div>
                <div class="media-container">
                    @foreach($movies['movies'] as $movie)
                        <div class="media">
                            @if(!Auth::guest())
                                @if(!empty($watchlist))
                                    @if(array_key_exists($movie['id'],$watchlist))
                                        <a class="in-watchlist" href="{{ route('movie.removeFromWatchlist', $movie['id']) }}">Remove</a>
                                    @else
                                        <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
                                    @endif
                                @elseif(!array_key_exists($movie['id'],$completed))
                                    <a class="out-watchlist" href="{{ route('movie.addToWatchlist', $movie['id']) }}">Add</a>
                                @else
                                    <a class="out-watchlist" href="">Completed</a>
                                @endif
                            @endif
                            <a class="media-links" href="{{ "/movies/".$movie['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$movie['poster_path']}}" alt="poster"></a>
                            <a class="media-links" href="{{ "/movies/".$movie['id'] }}">{{$movie['title']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach


@endsection

