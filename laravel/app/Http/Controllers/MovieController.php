<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;

        $moviesQuery = Movie::query();
        if ($busqueda) {
            $moviesQuery->where('title', 'LIKE', '%' . $busqueda . '%')
                ->paginate(2);
        }

        $movies = $moviesQuery->get();

        $files = File::all();
        $genres = Genre::all();

        $data = [
            'movies' => $movies,
            'files' => $files,
            'genres' => $genres,
        ];

        return view('movies.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view("movies.create", compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los archivos
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'genre_id' => 'required|exists:genres,id',
            'cover' => 'required|mimes:gif,jpeg,jpg,png,mp4',
            'intro' => 'required|mimes:gif,jpeg,jpg,png,mp4',
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $genreId = $request->get('genre_id');
        $cover = $request->file('cover');
        $intro = $request->file('intro');

        $filec = new File();
        $filecOk = $filec->diskSave($cover);

        $filei = new File();
        $fileiOk = $filei->diskSave($intro);

        if ($filecOk && $fileiOk) {
            Log::debug("Saving post at DB...");
            $movie = Movie::create([
                'title' => $title,
                'description' => $description,
                'genre_id' => $genreId,
                'cover_id' => $filec->id,
                'intro_id' => $filei->id,
            ]);
            Log::debug("DB storage OK");
            return redirect()->route('movies.show', $movie)
                ->with('success', __('Movie successfully saved'));
        } else {
            return redirect()->route("movies.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }


    private function saveFileAndGetId($file)
    {
        $fileModel = new File();
        if ($fileModel->diskSave($file)) {
            return $fileModel->id;
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $id = auth()->id();

        $reviews = $movie->reviews;
        return view('movies.show', [
            'movie' => $movie,
            'genres' => Genre::all(),
            'files' => File::all(),
            'reviews' => $reviews,
            'id' => $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        return view("movies.edit", [
            'movie' => $movie,
            "genres" => Genre::all(),
            "files" => File::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'genre_id' => 'required|exists:genres,id',
            'cover' => 'sometimes|required|mimes:gif,jpeg,jpg,png,mp4',
            'intro' => 'sometimes|required|mimes:gif,jpeg,jpg,png,mp4',
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $genreId = $request->get('genre_id');
        $cover = $request->file('cover');
        $intro = $request->file('intro');

        Log::debug("Updating post at DB...");
        $movie->update([
            'title' => $title,
            'description' => $description,
            'genre_id' => $genreId,
        ]);
        Log::debug("DB update OK");
        if ($cover) {
            $filec = new File();
            $filecOk = $filec->diskSave($cover);

            if ($filecOk) {
                // Actualizar el ID del archivo de portada
                $movie->update(['cover_id' => $filec->id]);
            }
        }

        if ($intro) {
            $filei = new File();
            $fileiOk = $filei->diskSave($intro);

            if ($fileiOk) {
                // Actualizar el ID del archivo de introducción
                $movie->update(['intro_id' => $filei->id]);
            }
        }
        // Redirigir con mensaje de éxito
        return redirect()->route('movies.show', $movie)
            ->with('success', __('Movie successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->reviews()->delete();
        if ($movie->file) {
            $movie->file->diskDelete();
        }
        $movie->delete();
        return redirect()->route("pages-home")->with('success', __('Movie successfully deleted'));
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    public function update_post(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    public function favorite(Movie $movie)
    {
        $favorite = Favorite::create([
            'user_id' => auth()->user()->id,
            'movie_id' => $movie->id,
        ]);
        return redirect()->back();
    }
    public function unfavorite(Movie $movie)
    {
        DB::table('favorites')
            ->where(['user_id' => Auth::id(), 'movie_id' => $movie->id])
            ->delete();

        return redirect()->back();
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
