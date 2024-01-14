<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Episode;


class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'movie_id',
        'serie_id',
        'episode_id',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
