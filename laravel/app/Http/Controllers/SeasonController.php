<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Serie;
use App\Models\File;
use App\Models\Episode;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeasonController extends Controller
{
    public function index(Serie $serie)
    {
        return view('seasons.index', [
            'serie' => $serie,
            'seasons' => Season::All(),
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

        $title = $request->input('title');
        $serie_id = $serie->id;

        if ($title) {
            $season = Season::create([
                'title' => $title,
                'serie_id' => $serie_id,
            ]);

            return redirect()->route('series.seasons.show', [$serie, $season])
                ->with('success', __('Season successfully created'));
        } else {
            return redirect()->route('series.show', $serie)
                ->with('error', __('Failed to create season'));
        }
    }

    public function show($serie, $season)
    {

        $id = auth()->id();
        $serie = Serie::findOrFail($serie);
        $season = Season::findOrFail($season);

        if (!$serie) {
            abort(404);
        }

        $seasons = $serie->seasons;

        $episodes = $season->episode;
        
        return view("seasons.show", [
            'episodes' => $episodes,
            'season' => $season,
            'serie' => $serie,
            'seasons' => $seasons,
            'files' => File::all(),
            "id" => $id,
        ]);
    }


    public function edit(Season $season)
    {
        return view("seasons.edit", [
            'season' => $season,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'serie_id' => 'required|exists:series,id',
        ]);

        $title = $request->input('title');
        $serie_id = $request->input('serie_id');

        $season->update([
            'title' => $title,
            'serie_id' => $serie_id,
        ]);

        Log::debug("DB update OK");
        return redirect()->route('series.seasons.show', ['serie' => $season->serie, 'season' => $season])
            ->with('success', __('Season successfully updated'));
    }



    public function destroy(Season $season)
    {
        if ($season) {

            $season->delete();
            return redirect()->route("pages-home")
                ->with('success', 'Season successfully deleted');
        } else {
            return redirect()->route("pages-home")
                ->with('error', __('Season error, no delete '));
        }
    }
}
