<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'serie_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
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
