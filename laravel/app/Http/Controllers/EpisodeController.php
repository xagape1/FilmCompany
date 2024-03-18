<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\Serie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;

        $episodesQuery = Episode::query();
        if ($busqueda) {
            $episodesQuery->where('title', 'LIKE', '%' . $busqueda . '%')
                ->paginate(2);
        }

        $episodes = $episodesQuery->get();

        $files = File::all();

        $data = [
            'episodes' => $episodes,
            'files' => $files,
        ];

        return view('episodes.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Serie $serie, Season $season)
    {
        $seasons = $serie->seasons;

        return view('episodes.create', compact('serie', 'season', 'seasons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Season $season, Episode $episode)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'cover' => 'required|mimes:gif,jpeg,jpg,png,mp4',
            'intro' => 'required|mimes:gif,jpeg,jpg,png,mp4',
        ]);

        $title = $request->get('title');
        $description = $request->get('description');

        $season_id = $request->get('season_id');

        $cover = $request->file('cover');
        $intro = $request->file('intro');

        $filec = new File();
        $filecOk = $filec->diskSave($cover);

        $filei = new File();
        $fileiOk = $filei->diskSave($intro);

        if ($filecOk && $fileiOk) {
            Log::debug("Saving post at DB...");
            $episode = Episode::create([
                'title' => $title,
                'description' => $description,
                'season_id' => $season_id,
                'cover_id' => $filec->id,
                'intro_id' => $filei->id,
            ]);

            return redirect()->route("pages-home")
                ->with('success', __('Episode successfully saved'));
        } else {
            return redirect()->route("episodes.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function show(Episode $episode)
    {
        $id = auth()->id();

        $comments = $episode->comments;
        $season = $episode->season;
        $serie = $season->serie;

        return view('episodes.show', [
            'episode' => $episode,
            'series' => Serie::all(),
            'season' => $season,
            'serie' => $serie,
            'files' => File::all(),
            'comments' => $comments,
            'id' => $id,
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function edit(Episode $episode)
    {
        return view("episodes.edit", [
            'episode' => $episode,
            'seasons' => Season::all(),
            'series' => Serie::all(),
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
    public function update(Request $request, Episode $episode)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'season_id' => 'required|exists:genres,id',
            'cover' => 'sometimes|required|mimes:gif,jpeg,jpg,png,mp4',
            'intro' => 'sometimes|required|mimes:gif,jpeg,jpg,png,mp4',
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $seasonId = $request->get('season_id');
        $cover = $request->file('cover');
        $intro = $request->file('intro');

        $episode->update([
            'title' => $title,
            'description' => $description,
            'season_id' => $seasonId,
        ]);

        if ($cover) {
            $filec = new File();
            $filecOk = $filec->diskSave($cover);

            if ($filecOk) {
                $episode->update(['cover_id' => $filec->id]);
            }
        }

        if ($intro) {
            $filei = new File();
            $fileiOk = $filei->diskSave($intro);

            if ($fileiOk) {
                $episode->update(['intro_id' => $filei->id]);
            }
        }
        // Redirigir con mensaje de éxito
        return redirect()->route('episodes.show', $episode)
            ->with('success', __('Episodes successfully updated'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Episode $episode)
    {
        $episode->comments()->delete();
        if ($episode->file) {
            $episode->file->diskDelete();
        }
        $episode->delete();
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

    public function favorite(Episode $episode)
    {
        $favorite = Favorite::create([
            'user_id' => auth()->user()->id,
            'episode_id' => $episode->id,
        ]);
        return redirect()->back();
    }
    public function unfavorite(Episode $episode)
    {
        DB::table('favorites')
            ->where(['user_id' => Auth::id(), 'episode_id' => $episode->id])
            ->delete();

        return redirect()->back();
    }
}
