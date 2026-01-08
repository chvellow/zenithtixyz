<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model

{
    // use HasFactory;
    // Tambahkan ini jika nama tabel di phpMyAdmin adalah 'movies'
    protected $table = 'movies';
    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration',
        'rating',
        'poster',
    ];

    
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    
}

