<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Movie;
use App\Models\File;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        $series = Serie::all();

        $files = File::all();

        $data = [
            'movies' => $movies,
            'series' => $series,
            'files' => $files,
        ];

        $favoriteMovies = Auth::user()->favorited()->get();

        return view('favorites.index', ['data' => $data, 'favoriteMovies' => $favoriteMovies]);
    }
}
