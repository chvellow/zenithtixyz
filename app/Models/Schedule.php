<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// WAJIB TAMBAHKAN DUA BARIS INI DI ATAS
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'movie_id',
        'studio_id', 
        'date',
        'time',
        'price'
    ];

    /**
     * Relasi ke Movie
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Relasi ke Order (Ini yang tadi bikin error)
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi ke Studio
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }
}