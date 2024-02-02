<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_id',
        'intro_id',
        'season_id',
    ];
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function comprovarfavorite()
    {
        $episode_id = $this->id;
        $user_id = auth()->user()->id;
        $select = "SELECT id FROM favorites WHERE $episode_id = $episode_id and user_id = $user_id";
        $id_favorite = DB::select($select);
        return empty($id_favorite);
    }
}
