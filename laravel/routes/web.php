<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FavoriteController;

$controller_path = 'App\Http\Controllers';



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified', 'role:admin|pay'
])->group(function () {
    $controller_path = 'App\Http\Controllers';

    Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
    Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');

});

Route::resource('files', FileController::class)
    ->middleware(['auth']);

    Route::resource('movies', MovieController::class)
    ->middleware(['auth']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin|pay'])->group(function () {
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])->group(function () {
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
});

Route::resource('movies.reviews', ReviewsController::class)->middleware(['auth']);


Route::post('/movies/{movie}/favorites', [App\Http\Controllers\MovieController::class, 'favorite'])->name('movies.favorite');
Route::delete('/movies/{movie}/favorites', [App\Http\Controllers\MovieController::class, 'unfavorite'])->name('movies.unfavorite');




Route::middleware(['auth'])->group(function () {

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});
