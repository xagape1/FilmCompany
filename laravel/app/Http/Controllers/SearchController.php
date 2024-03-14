<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Episode;
use App\Models\File;
use App\Models\Genre;
use App\Models\Season;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;
        $searchType = $request->searchType;

        $moviesQuery = Movie::query();
        $seriesQuery = Serie::query();

        if ($busqueda) {
            if ($searchType == 'movies' || $searchType == 'both') {
                $moviesQuery->where('title', 'LIKE', '%' . $busqueda . '%');
            }

            if ($searchType == 'series' || $searchType == 'both') {
                $seriesQuery->where('title', 'LIKE', '%' . $busqueda . '%');
            }
        }

        $movies = $moviesQuery->get();
        $series = $seriesQuery->get();

        $files = File::all();
        $genres = Genre::all();
        $seasons = Season::all();

        $data = [
            'movies' => $movies,
            'series' => $series,
            'files' => $files,
            'genres' => $genres,
            'seasons' => $seasons,
        ];

        return view('search.index', $data);
    }
    public function handleSubscription()
    {
      $user = Auth::user();
  
      if ($user->hasRole('new')) {
        $removeNew = Role::where('name', 'new')->first();
        $addPay = Role::firstOrCreate(['name' => 'pay', 'guard_name' => 'web']);
  
        if ($removeNew) {
          $user->removeRole($removeNew);
          $user->assignRole($addPay);
        }
      }
  
      return redirect()->route('pages-home');
    }
}
