<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Movie;
use Illuminate\Support\Facades\Log;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     
     * @return \Illuminate\Http\Response
     */
    public function index(Movie $movie)
    {
        return view("reviews.index", [
            "reviews" => Review::all(),
            "movie" => $movie,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Movie $movie)
    {
        return view("reviews.create", [
            "movie" => $movie,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ... tu código anterior ...

    public function store(Request $request, Movie $movie)
    {
        // Validar datos del formulario
        $validatedData = $request->validate([
            'description' => 'required',
        ]);

        // Obtener datos del formulario
        $description = $request->get('description');
        $movie_id = $movie->id;
        $author_id = auth()->user()->id;  // Obtener el ID del usuario actual

        if ($description) {
            // Almacenar datos en BD
            Log::debug("Saving post at DB...");
            $review = Review::create([
                'description' => $description,
                'movie_id' => $movie_id,
                'author_id' => $author_id,
            ]);
            Log::debug("DB storage OK");
            // Patrón PRG con mensaje de éxito
            return redirect()->route('movies.reviews.show', [$movie, $review])
                ->with('success', __('Coment successfully saved'));
        } else {
            // Patrón PRG con mensaje de error
            return redirect()->route("movies.reviews.create", $movie)
                ->with('error', __('ERROR Uploading file'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie, Review $review)
    {
        $id = auth()->id();
        return view("reviews.show", [
            'review' => $review,
            "movie" => $movie,
            'author' => $review->user,
            "id" => $id,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie, Review $review)
    {
        if ($review->author_id == auth()->id()) {
            // Eliminar place de BD
            $review->delete();
            // Patró PRG amb missatge d'èxit
            return redirect()->route("movies.reviews.index", $movie)
                ->with('success', 'Resena successfully deleted');
        } else {
            return redirect()->route("movies.reviews.show", [$movie, $review])
                ->with('error', __('No ets el propietari de la reseña'));
        }

    }
}