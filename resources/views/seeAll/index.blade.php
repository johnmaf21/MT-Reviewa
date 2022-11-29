@extends('layouts.app2')

@section('content')
    <div class="title">
        <h1>{{$typeQuery}}</h1>
    </div>

    @for($y=0; $y<4; $y++)
        <div class="see-all-media">
                @for($x=0; $x<5; $x++)
                    @if(array_key_exists(($y+($x*$y)+4), $results))
                        <div class="see-all-container">
                            @if(array_key_exists('name',$results[$y+(($x*$y)+4)]))
                                <div class="media">
                                    <a class="media-links" href="{{ "/tvshows/".$results[$y+(($x*$y))]['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$results[$y+(($x*$y))]['poster_path']}}" alt="poster"></a>
                                    <a class="media-links" href="{{ "/tvshows/".$results[$y+(($x*$y))]['id'] }}">{{$results[$y+(($x*$y))]['name']}}</a>
                                </div>
                            @else
                                <div class="media">
                                    <a class="media-links" href="{{ "/movies/".$results[$y+(($x*$y))]['id'] }}"><img src="{{"https://image.tmdb.org/t/p/w154".$results[$y+(($x*$y))]['poster_path']}}" alt="poster"></a>
                                    <a class="media-links" href="{{ "/movies/".$results[$y+(($x*$y))]['id'] }}">{{$results[$y+(($x*$y))]['title']}}</a>
                                </div>
                            @endif
                        </div>
                    @endif
                @endfor
        </div>
    @endfor

    <>


@endsection
