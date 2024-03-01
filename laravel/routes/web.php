<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SerieController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\EpisodeController;

$controller_path = 'App\Http\Controllers';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    $controller_path = 'App\Http\Controllers';

    Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
    Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');
});


/**
 * 
 * GENERAL
 * 
 */

Route::resource('files', FileController::class)
    ->middleware(['auth']);

Route::resource('movies', MovieController::class)
    ->middleware(['auth']);

Route::resource('series.seasons', SeasonController::class)->middleware(['auth']);


/**
 * 
 * ADMIN Y PAGO
 * 
 */

Route::get('/series/{serie}/seasons', 'SeasonController@index')->name('seasons.index');
Route::get('/series/{serie}/seasons/{season}', 'SeasonController@show')->name('series.seasons.show');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/series', [SerieController::class, 'index'])->name('series.index');
Route::get('/series/{serie}', [SerieController::class, 'show'])->name('series.show');


Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');





/**
 * 
 * ADMINS
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
});


/**
 * 
 * REVIEWS MOVIES
 * 
 */

Route::resource('movies.reviews', ReviewsController::class)->middleware(['auth']);

/**
 * 
 * REVIEWS EPISODES
 * 
 */

Route::resource('episodes.comments', CommentsController::class)->middleware(['auth']);

Route::middleware(['auth'])->group(function () {

    /**
     * 
     * FAVORITES MOVIES
     * 
     */

    Route::post('/movies/{movie}/favorites', [App\Http\Controllers\MovieController::class, 'favorite'])->name('movies.favorite');
    Route::delete('/movies/{movie}/favorites', [App\Http\Controllers\MovieController::class, 'unfavorite'])->name('movies.unfavorite');

    /**
     * 
     * FAVORITES SERIES
     * 
     */

    Route::post('/series/{serie}/favorites', [App\Http\Controllers\SerieController::class, 'favorite'])->name('series.favorite');
    Route::delete('/series/{serie}/favorites', [App\Http\Controllers\SerieController::class, 'unfavorite'])->name('series.unfavorite');

    /**
     * 
     * FAVORITES EPISODES
     * 
     */

    Route::post('/episodes/{episode}/episodes', [App\Http\Controllers\EpisodeController::class, 'favorite'])->name('episodes.favorite');
    Route::delete('/episodes/{episode}/episodes', [App\Http\Controllers\EpisodeController::class, 'unfavorite'])->name('episodes.unfavorite');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});
