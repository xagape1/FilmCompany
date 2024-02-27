<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Episode;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     
     * @return \Illuminate\Http\Response
     */
    public function index(Episode $episode)
    {
        return view("comments.index", [
            "comments" => Comment::all(),
            "episode" => $episode,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Episode $episode)
    {
        return view("episodes.create", [
            "episode" => $episode,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, Episode $episode)
    {
        $validatedData = $request->validate([
            'description' => 'required',
        ]);

        $description = $request->get('description');
        $episode_id = $episode->id;
        $author_id = auth()->user()->id;

        if ($description) {
            Log::debug("Saving post at DB...");
            $comment = Comment::create([
                'description' => $description,
                'episode_id' => $episode_id,
                'author_id' => $author_id,
            ]);
            return redirect()->route('episodes.show', $episode)
                ->with('success', __('Episode successfully saved'));
        } else {
            return redirect()->route('episodes.show', $episode)
                ->with('success', __('Episode successfully saved'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Episode $episode, Comment $comment)
    {
        $id = auth()->id();
        return view("comments.show", [
            'comment' => $comment,
            "episode" => $episode,
            'author' => $comment->user,
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
    public function destroy(Episode $episode, Comment $comment)
    {
        if ($comment->author_id == auth()->id() || auth()->user()->hasRole('admin')) {
            // Eliminar reseña de BD
            $comment->delete();
            // Patrón PRG con mensaje de éxito
            return redirect()->route('episode.show', $episode)
                ->with('success', __('Review successfully deleted'));
        } else {
            // Patrón PRG con mensaje de error
            return redirect()->route('episode.show', $episode)
                ->with('error', __('You do not have permission to delete this review'));
        }
    }
}