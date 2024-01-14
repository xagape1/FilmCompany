<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Serie;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;

        $serieQuery = Serie::query();
        if ($busqueda) {
            $serieQuery->where('title', 'LIKE', '%' . $busqueda . '%')
                ->paginate(2);
        }

        $series = $serieQuery->get();

        $files = File::all();
        $genres = Genre::all();

        $data = [
            'series' => $series,
            'files' => $files,
            'genres' => $genres,
        ];

        return view('series.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all(); // Asumiendo que tienes un modelo Genre para la tabla de géneros
        return view("series.create", compact('genres'));
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
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $genreId = $request->get('genre_id');
        $cover = $request->file('cover');

        $filec = new File();
        $filecOk = $filec->diskSave($cover);

        if ($filecOk) {
            // Guardar los datos en la BD
            Log::debug("Saving post at DB...");
            $serie = Serie::create([
                'title' => $title,
                'description' => $description,
                'genre_id' => $genreId,
                'cover_id' => $filec->id,
            ]);
            Log::debug("DB storage OK");
            // Redirigir con mensaje de éxito
            return redirect()->route('series.show', $serie)
                ->with('success', __('Movie successfully saved'));
        } else {
            Log::debug("ERROR");
            // Redirigir con mensaje de error
            return redirect()->route("series.create")
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
     * @param \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show(Serie $serie)
    {
        $id = auth()->id();

        return view('series.show', [
            'serie' => $serie,
            'genre' => Genre::all(),
            'files' => File::all(),
            'id' => $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function edit(Serie $serie)
    {
        return view("series.edit", [
            'serie' => $serie,
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
    public function update(Request $request, Serie $serie)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'genre_id' => 'required|exists:genres,id',
            'cover' => 'sometimes|required|mimes:gif,jpeg,jpg,png,mp4',
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $genreId = $request->get('genre_id');
        $cover = $request->file('cover');

        // Actualizar los datos de la película en la BD
        Log::debug("Updating post at DB...");
        $serie->update([
            'title' => $title,
            'description' => $description,
            'genre_id' => $genreId,  // Asegúrate de actualizar 'genre_id'
        ]);
        Log::debug("DB update OK");

        // Actualizar archivos solo si se proporcionan nuevos archivos
        if ($cover) {
            $filec = new File();
            $filecOk = $filec->diskSave($cover);

            if ($filecOk) {
                // Actualizar el ID del archivo de portada
                $serie->update(['cover_id' => $filec->id]);
            }
        }
        
        // Redirigir con mensaje de éxito
        return redirect()->route('series.show', $serie)
            ->with('success', __('Movie successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serie $serie)
    {
        if ($serie->file) {
            $serie->file->diskDelete();
        }
        $serie->delete();
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
    public function favorite(Serie $serie)
    {
        $favorite = Favorite::create([
            'user_id' => auth()->user()->id,
            'serie_id' => $serie->id,
        ]);
        return redirect()->back();

    }
    public function unfavorite(Serie $serie)
    {
        DB::table('favorites')
            ->where(['user_id' => Auth::id(), 'serie_id' => $serie->id])
            ->delete();

        return redirect()->back();
    }



}
