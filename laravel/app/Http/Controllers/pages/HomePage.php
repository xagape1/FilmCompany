<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\File;
use App\Models\Serie;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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

    return redirect()->route('pages-home'); // Redirige según sea necesario
  }

}
