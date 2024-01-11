<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\File;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        $files = File::all();

        $data = [
            'movies' => $movies,
            'files' => $files,
        ];

        $favoriteMovies = Auth::user()->favorited()->get();

        return view('favorites.index', ['data' => $data, 'favoriteMovies' => $favoriteMovies]);
    }
}
