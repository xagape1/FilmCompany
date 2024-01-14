<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Episode;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $busqueda = $request->busqueda;
        $contentType = $request->content_type;

        if ($contentType === 'movies') {
            $results = Movie::where('title', 'LIKE', '%' . $busqueda . '%')->get();
        } elseif ($contentType === 'series') {
            $results = Serie::where('title', 'LIKE', '%' . $busqueda . '%')->get();
        } elseif ($contentType === 'episodes') {
            $results = Episode::where('title', 'LIKE', '%' . $busqueda . '%')->get();
        } 

        return view('search.index', [
            'results' => $results,
        ]);
    }
}
