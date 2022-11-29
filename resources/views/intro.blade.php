@extends('layouts.app2')

@section('content')
    <div class="intro__title">
        <h1>Tutorial</h1>
    </div>
    <div class="intro__text">
        <p>Welcome again to MT Review! To get started with MT Reviews, we suggest you go to the movies or tv shows page
            to add everything you have watched or are planning to watch.
            From there you can add comments and rate your favorite things you've watched</p>
        <div>
            <a class="intro__button" href="/movies">Movies</a>
            <a class="intro__button" href="/tvshows">Tv Shows</a>
        </div>

    </div>
@endsection
