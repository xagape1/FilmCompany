<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'author_id',
        'movie_id',
        'episode_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
