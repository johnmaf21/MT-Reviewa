@extends('layouts.app')

@section('content')
    <div class="posterHeader">
        <img src="poster.png" alt="poster">
    </div>
    <div class="profilePic">
        <img src="{{ Auth::user()->profile_pic }}" alt="profile picture">
    </div>
    <div class="username">
        <p>{{ Auth::user()->username }}</p>
    </div>
    <div class="profileOptions">
        <p>
            <a href="{{ route('displayWatchlist') }}"> watchlist </a> |
            <a href="{{ route('displayComments') }}"> Comments </a> |
            <a href="{{ route('displayReplies') }}"> Replies </a> |
            <a href="{{ route('displayLikes') }}"> likes </a>
        </p>
    </div>

    <section class="profileContent">
        <div class="container mx-auto">
            @yield('profileContent')
        </div>
    </section>
@endsection

