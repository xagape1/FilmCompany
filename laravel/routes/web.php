<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\ReviewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\EpisodeController;
use App\Models\Favorite;

$controller_path = 'App\Http\Controllers';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    $controller_path = 'App\Http\Controllers';

    Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
});

/**
 * 
 * TODOS PUEDEN VER Y HACER
 * 
 */

Route::get('/series/{serie}/seasons', 'SeasonController@index')->name('seasons.index')->middleware(['auth']);
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index')->middleware(['auth']);
Route::get('/series', [SerieController::class, 'index'])->name('series.index')->middleware(['auth']);
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index')->middleware(['auth']);
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::post('/subscribe', [HomePage::class, 'handleSubscription'])->name('handleSubscription')->middleware(['auth']);


/**
 * 
 * GENERAL
 * 
 */

Route::resource('files', FileController::class)
    ->middleware(['auth']);

Route::resource('movies', MovieController::class)
    ->middleware(['auth']);

Route::resource('series.seasons', SeasonController::class)
    ->middleware(['auth']);


/**
 * 
 * FAVORITES 
 * 
 */

Route::post('/movies/{movie}/favorites', [App\Http\Controllers\MovieController::class, 'favorite'])->name('movies.favorite')->middleware(['auth']);
Route::delete('/movies/{movie}/favorites', [App\Http\Controllers\MovieController::class, 'unfavorite'])->name('movies.unfavorite')->middleware(['auth']);

Route::post('/series/{serie}/favorites', [App\Http\Controllers\SerieController::class, 'favorite'])->name('series.favorite')->middleware(['auth']);
Route::delete('/series/{serie}/favorites', [App\Http\Controllers\SerieController::class, 'unfavorite'])->name('series.unfavorite')->middleware(['auth']);

Route::post('/episodes/{episode}/episodes', [App\Http\Controllers\EpisodeController::class, 'favorite'])->name('episodes.favorite')->middleware(['auth']);
Route::delete('/episodes/{episode}/episodes', [App\Http\Controllers\EpisodeController::class, 'unfavorite'])->name('episodes.unfavorite')->middleware(['auth']);

/**
 * 
 * REVIEWS
 * 
 */

Route::resource('movies.reviews', ReviewsController::class)->middleware(['auth'])->middleware(['auth']);
Route::resource('episodes.comments', CommentsController::class)->middleware(['auth'])->middleware(['auth']);

/**
 * 
 * ADMIN
 * 
 */



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/series/{serie}/seasons/{season}', 'SeasonController@show')->name('series.seasons.show');
    Route::get('/series/{serie}/seasons', 'SeasonController@index')->name('seasons.index');


    Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

    Route::get('/series/{serie}', [SerieController::class, 'show'])->name('series.show');

    Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');
});


/**
 * 
 * ADMIN
 * 
 */

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])->group(function () {
    /**
     * 
     * MOVIES
     * 
     */

    Route::post('/admin/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/admin/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::put('/admin/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/admin/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
    Route::get('/admin/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    /**
     * 
     * SERIES
     * 
     */

    Route::post('/series', [SerieController::class, 'store'])->name('series.store');
    Route::get('/admin/series/create', [SerieController::class, 'create'])->name('series.create');
    Route::put('/admin/series/{serie}', [SerieController::class, 'update'])->name('series.update');
    Route::delete('/admin/series/{serie}', [SerieController::class, 'destroy'])->name('series.destroy');
    Route::get('/series/{serie}/edit', [SerieController::class, 'edit'])->name('series.edit');

    /**
     * 
     * SEASONS
     * 
     */
    Route::post('/admin/series/{serie}/seasons', [SeasonController::class, 'store'])->name('seasons.store');
    Route::get('/admin/seasons/{season}/edit', [SeasonController::class, 'edit'])->name('seasons.edit');
    Route::put('/admin/seasons/{season}/update', [SeasonController::class, 'update'])->name('seasons.update');
    Route::delete('/admin/seasons/{season}/destroy', [SeasonController::class, 'destroy'])->name('seasons.destroy');

    /**
     * 
     * EPISODES
     * 
     */
    Route::post('/admin/episodes', [EpisodeController::class, 'store'])->name('episodes.store');
    Route::get('/admin/series/{serie}/seasons/{season}/episodes/episode', [EpisodeController::class, 'create'])->name('episodes.create');
    Route::get('/admin/episodes/{episode}/edit', [EpisodeController::class, 'edit'])->name('episodes.edit');
    Route::delete('/admin/episodes/{episode}/destroy', [EpisodeController::class, 'destroy'])->name('episodes.destroy');
    Route::put('/admin/episodes/{episode}/update', [EpisodeController::class, 'update'])->name('episodes.update');
});
