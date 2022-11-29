<?php

namespace App\Models;

use GuzzleHttp\Client;

class GetApiData
{
    public function __construct(String $mediaType){
        $this->mediaType = $mediaType;
    }
    /**
     * @throws \JsonException
     */
    public function getData($url){
        $client = new Client();
        $response = $client->request('GET', $url);
        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getReviewComments($id, $page){
        return $this->getData("https://api.themoviedb.org/3/".$this->mediaType."/".$id."/reviews?api_key=".env('TMDB_API')."&language=en-US&page=".$page);
    }

    public function getEpisodeData($id, $season, $episode){
        return $this->getData("https://api.themoviedb.org/3/tv/".$id."/season/".$season."/episode/".$episode."?api_key=1c2eda9fefdbe3e6bda237e311c86871&language=en-US&append_to_response=videos,images,credits,external_ids");
    }

    public function getSeasonData($id, $season){
        return $this->getData("https://api.themoviedb.org/3/tv/".$id."/season/".$season."?api_key=1c2eda9fefdbe3e6bda237e311c86871&language=en-US");
    }

    public function getMediaData($id){
        return $this->getData("https://api.themoviedb.org/3/".$this->mediaType."/".$id."?api_key=".env('TMDB_API')."&language=en-US&append_to_response=videos,images,credits,external_ids,recommendations");
    }

    public function getSearchResults($query, $page){
        return $this->getData("https://api.themoviedb.org/3/search/multi?api_key=".env('TMDB_API')."&language=en-US&query=".$query."&page=".$page."&include_adult=false");
    }

    public function getSimilarMediaData($id){
        return $this->getData("https://api.themoviedb.org/3/".$this->mediaType."/".$id."/similar?api_key=".env('TMDB_API')."&language=en-US&page=1");
    }

    public function getPopularData($page){
        return $this->getData("https://api.themoviedb.org/3/".$this->mediaType."/popular?api_key=".env('TMDB_API')."&language=en-US&page=".$page);
    }

    public function getTrendingData($page){
        return $this->getData("https://api.themoviedb.org/3/trending/".$this->mediaType."/week?api_key=1c2eda9fefdbe3e6bda237e311c86871&page=".$page);
    }

    public function getInTheatresData($page){
        return $this->getData("https://api.themoviedb.org/3/movie/now_playing?api_key=1c2eda9fefdbe3e6bda237e311c86871&language=en-US&page=".$page);
    }

    public function getUpcomingData($page){
        return $this->getData("https://api.themoviedb.org/3/movie/upcoming?api_key=".env('TMDB_API')."&language=en-US&page=".$page);
    }

    public function getOnAirData($page){
        return $this->getData("https://api.themoviedb.org/3/tv/on_the_air?api_key=".env('TMDB_API')."&language=en-US&page=".$page);
    }

    public function getTopRatedData($page){
        return $this->getData("https://api.themoviedb.org/3/".$this->mediaType."/top_rated?api_key=".env('TMDB_API')."&language=en-US&page=".$page);
    }

    public function getWatchProvider($id){
        return $this->getData("https://api.themoviedb.org/3/".$this->mediaType."/".$id."/watch/providers?api_key=".env('TMDB_API'));
    }

    public function getGenres(){
        return $this->getData("https://api.themoviedb.org/3/genre/".$this->mediaType."/list?api_key=".env('TMDB_API')."&language=en-US");
    }

    public function getDiscoverMedia($genre, $page){
        return $this->getData("https://api.themoviedb.org/3/discover/".$this->mediaType."?api_key=".env('TMDB_API')."&language=en-US&include_adult=false&page=".$page."&with_genres=".$genre."&with_watch_monetization_types=flatrate");
    }


}
