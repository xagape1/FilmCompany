<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function create()
    {
        $genres = Genre::all();
        return view('/movies', compact('genres'));
    }
}
