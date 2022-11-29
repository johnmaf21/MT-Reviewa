<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SeeAllController;
use App\Http\Controllers\TvShowsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecificMovieController;
use App\Http\Controllers\SpecificTvShowController;
use App\Http\Controllers\SpecificEpisodeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Routes for login view
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/auth/github/callback',[LoginController::class, 'githubLogin']);
Route::get('/auth/google/callback',[LoginController::class, 'googleLogin']);
Route::get('/auth/twitter/callback',[LoginController::class, 'twitterLogin']);
Route::get('/auth/linkedin/callback',[LoginController::class, 'linkedInLogin']);

Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/auth/twitter/redirect', function () {
    return Socialite::driver('twitter')->redirect();
});
Route::get('/auth/linkedin/redirect', function () {
    return Socialite::driver('linkedin')->redirect();
});

//Routes for register view
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'registerUser'])->name('registerUser');

Route::get('/password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/login/verify', [LoginController::class, 'showTwoFactor'])->name('showTwoFactor');
Route::post('/login/two-factor', [LoginController::class, 'twoFactor'])->name('login.twoFactor');
Route::get('/login/resend', [LoginController::class, 'resend'])->name('login.resend');

Route::get('/movies/{movie}', [MoviesController::class, 'openSpecificMovie'])->name('movie.openSpecificMovie');
Route::get('/tvshows/{tvShow}', [TvShowsController::class, 'openSpecificTvShow'])->name('tvShow.openSpecificTvShow');
Route::get('/movies/see-all/{type}/{typeQuery}/{id}', [MoviesController::class, 'displaySeeAll'])->name('movie.displaySeeAll');
Route::get('/tvshows/see-all/{type}/{typeQuery}/{id}', [TvShowsController::class, 'displaySeeAll'])->name('tvShow.displaySeeAll');
Route::get('/{mediaType}/seeAll/{type}/{typeQuery}/{id}/{page}', [SeeAllController::class, 'getNewPage'])->name('seeAll.getNewPage');
Route::get('/{mediaType}/seeAll/{type}/{typeQuery}/{id}/{page}/{mediaId}', [SeeAllController::class, 'openSpecificMedia'])->name('seeAll.openSpecificMedia');


//Routes to displays movies/tvshows for multiple genres
Route::get('/movies', [MoviesController::class, 'index'])->name('index');
Route::get('/tvshows', [TvShowsController::class, 'index'])->name('index');

//Routes to edit the movie watchlist
Route::get('/movies/{movie}/add-to-watchlist', [MoviesController::class, 'addToWatchlist'])->name('movie.addToWatchlist');
Route::get('/movies/{movie}/remove-from-watchlist', [MoviesController::class, 'removeFromWatchlist'])->name('movie.removeFromWatchlist');

//Routes to edit the tvshow watchlist
Route::get('/tvshows/{tvShow}/add-to-watchlist', [TvShowsController::class, 'addToWatchlist'])->name('tvShow.addToWatchlist');
Route::get('/tvshows/{tvShow}/remove-from-watchlist', [TvShowsController::class, 'removeFromWatchlist'])->name('tvShow.removeFromWatchlist');


Route::get('/movies/seeAll/{type}/{typeQuery}/{id}', [MoviesController::class, 'displaySeeAll'])->name('movie.displaySeeAll');
Route::get('/tvshows/seeAll/{type}/{typeQuery}/{id}', [TvShowsController::class, 'displaySeeAll'])->name('tvShow.displaySeeAll');


Route::get('/{mediaType}/seeAll/{type}/$/{typeQuery}/{id}/{page}/{mediaId}/add-to-watchlist', [SeeAllController::class, 'addToWatchlist'])->name('seeAll.addToWatchlist');
Route::get('/{mediaType}/seeAll/{type}/$/{typeQuery}/{id}/{page}/{mediaId}/remove-from-watchlist', [SeeAllController::class, 'removeFromWatchlist'])->name('seeAll.removeFromWatchlist');

Route::get('/movies/{movie}/{mediaUser}/{hasLiked}/update-like', [SpecificMovieController::class, 'updateLike'])->name('movie.updateLike');
Route::get('/movies/{movie}/{mediaUser}/{hasWatched}/has-watched', [SpecificMovieController::class, 'hasWatched'])->name('movie.hasWatched');
Route::get('/movies/{movie}/{userComment}/remove-comment', [SpecificMovieController::class, 'removeComment'])->name('movie.removeComment');
Route::get('/movies/{movie}/{userReply}/remove-reply', [SpecificMovieController::class, 'removeReply'])->name('movie.removeReply');
Route::post('/movies/{movie}/{review}/post-comment', [SpecificMovieController::class, 'postComment'])->name('movie.postComment');
Route::get('/movies/{movie}/{userComment}/post-reply', [SpecificMovieController::class, 'postReply'])->name('movie.postReply');

Route::prefix('/tvshows/{tvShow}')->group(function (){
    Route::post('/{mediaUser}/{hasLiked}update-like', [SpecificTvShowController::class, 'updateLike'])->name('tvShow.updateLike');
    Route::post('/{mediaUser}/{hasWatched}/has-watched', [SpecificTvShowController::class, 'hasWatched'])->name('tvShow.hasWatched');
    Route::post('/{userComment}/remove-comment', [SpecificTvShowController::class, 'removeComment'])->name('tvShow.removeComment');
    Route::post('/{userReply}/remove-reply', [SpecificTvShowController::class, 'removeReply'])->name('tvShow.removeReply');
    Route::post('/{review}/post-comment', [SpecificTvShowController::class, 'postComment'])->name('tvShow.postComment');
    Route::post('/{userComment}/post-reply', [SpecificTvShowController::class, 'postReply'])->name('tvShow.postReply');
    Route::post('/{mediaUser}/{mediaId}/{episodeId}/{season}/{episode}/{hasWatched}', [SpecificTvShowController::class, 'hasWatchedEpisode'])->name('tvShow.hasWatchedEpisode');
    Route::post('/{mediaUser}/{mediaId}/{episodeId}/{season}/{episode}/{hasWatched}/{checkRest}', [SpecificTvShowController::class, 'hasWatchedEpisodes'])->name('tvShow.hasWatchedEpisodes');
    Route::get('/{episodes}', [SpecificTvShowController::class, 'openSpecificEpisode'])->name('tvShow.openSpecificEpisode');
});

Route::post('/tvshows/{tvShow}/{episodes}/{mediaUser}/{hasLiked}/update-like', [SpecificEpisodeController::class, 'updateEpisodeLike'])->name('episode.updateEpisodeLike');
Route::post('/tvshows/{tvShow}/{episodes}/{mediaUser}/{hasWatched}/has-watched', [SpecificEpisodeController::class, 'hasWatched'])->name('episode.hasWatched');
Route::post('/tvshows/{tvShow}/{episodes}/{userComment}/remove-comment', [SpecificEpisodeController::class, 'removeComment'])->name('episode.removeComment');
Route::post('/tvshows/{tvShow}/{episodes}/{userReply}/remove-reply', [SpecificEpisodeController::class, 'removeReply'])->name('episode.removeReply');
Route::post('/tvshows/{tvShow}/{episodes}/{review}/post-comment', [SpecificEpisodeController::class, 'postComment'])->name('episode.postComment');
Route::post('/tvshows/{tvShow}/{episodes}/{userComment}/post-reply', [SpecificEpisodeController::class, 'postReply'])->name('episode.postReply');
Route::post('/tvshows/{tvShow}/{episodes}/{mediaUser}/{mediaId}/{episodeId}/{season}/{episode}/{hasWatched}', [SpecificEpisodeController::class, 'hasWatchedEpisode'])->name('episode.hasWatchedEpisode');


Route::get('/profile', [ProfileController::class, 'displayWatchlist'])->name('displayWatchlist');
Route::get('/profile', [ProfileController::class, 'displayComments'])->name('displayComments');
Route::get('/profile', [ProfileController::class, 'displayLikes'])->name('displayLikes');
Route::get('/profile', [ProfileController::class, 'displayReplies'])->name('displayReplies');

Route::get('/', function () {
    if (!Auth::guest() || Auth::viaRemember()){
        if(Auth::user()->two_factor_code !== null){
            Auth::logout();
            return view('/home');
        }
        return view('/intro');
    }
    return view('/home');
});

Route::get('/intro', function (){
    if(!Auth::guest()){
        if(Auth::user()->two_factor_code !== null){
            Auth::logout();
        }
    }

    return view('/intro');
});

