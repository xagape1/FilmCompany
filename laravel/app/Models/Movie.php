<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'gender',
        'cover_id',
        'intro_id',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
    
}