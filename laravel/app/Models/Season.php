<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'serie_id',
    ];


    public function create()
    {
        $seasons = Season::all();
        return view('/series', compact('seasons'));
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }


    public function episode()
    {
        return $this->hasMany(Episode::class);
    }
}
