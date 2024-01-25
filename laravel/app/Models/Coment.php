<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coment extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'author_id',
        'episode_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
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
