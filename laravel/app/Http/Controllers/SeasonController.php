<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Serie;

class SeasonController extends Controller
{
    public function index(Serie $serie)
    {
        return view("seasons.index", [
            "seasons" => Season::all(),
            "serie" => $serie,
        ]);
    }

    public function create(Serie $serie)
    {
        return view("seasons.create", [
            "serie" => $serie,
        ]);
    }

    public function store(Request $request, Serie $serie)
    {
        $validatedData = $request->validate([
            'title' => 'required',
        ]);

        $title = $request->get('title');
        $serie_id = $serie->id;
        if ($title) {
            // Almacenar datos en BD
            $season = Season::create([
                'title' => $title,
                'serie_id' => $serie_id,
            ]);

            return redirect()->route('series.show', $serie)
                ->with('success', __('Season successfully saved'));
        } else {
            // Patrón PRG con mensaje de error
            return redirect()->route('series.show', $serie)
                ->with('success', __('Season successfully saved'));
        }
    }


    public function show(Serie $serie, Season $season)
    {
        $id = auth()->id();
        return view("seasons.show", [
            'season' => $season,
            "serie" => $serie,
            "id" => $id,
        ]);
    }

    public function edit($id)
    {
        $season = Season::find($id);
        return view('seasons.edit', compact('season'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'serie_id' => 'required|exists:series,id',
        ]);

        $season = Season::find($id);
        $season->update($validatedData);

        return redirect()->route('seasons.show', $season->id);
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        $season->delete();

        return redirect()->route('seasons.index');
    }
}
