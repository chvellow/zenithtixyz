<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'movie_id'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
