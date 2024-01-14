<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\File;
use App\Models\Serie;

class HomePage extends Controller
{
  public function index()
  {
    $genres = Genre::all();
    $series = Serie::all();
    $movies = Movie::all();
    $files = File::all();

    $data = [
      'genres' => $genres,
      'series' => $series,
      'movies' => $movies,
      'files' => $files,
    ];

    return view('content.pages.pages-home', $data);
  }
}