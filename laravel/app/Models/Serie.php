<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre_id',
        'cover_id',
    ];
    public function season()
    {
        return $this->hasMany(Season::class);
    }
    public function file()
    {
        return $this->belongsTo(File::class);
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
        $serie_id = $this->id;
        $user_id = auth()->user()->id;
        $select = "SELECT id FROM favorites WHERE $serie_id = $serie_id and user_id = $user_id";
        $id_favorite = DB::select($select);
        return empty($id_favorite);
    }

}
