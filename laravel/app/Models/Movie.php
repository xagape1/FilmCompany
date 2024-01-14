<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Favorite;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre_id',
        'cover_id',
        'intro_id',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function genres()
    {
        return $this->hasMany(Genre::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function comprovarfavorite()
    {
        $movie_id = $this->id;
        $user_id = auth()->user()->id;
        $select = "SELECT id FROM favorites WHERE $movie_id = $movie_id and user_id = $user_id";
        $id_favorite = DB::select($select);
        return empty($id_favorite);
    }


}