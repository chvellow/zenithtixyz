<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    // Tambahkan 'type' ke dalam array ini agar bisa disimpan ke database
    protected $fillable = [
        'name', 
        'capacity', 
        'type', // <-- WAJIB ADA INI
        'total_rows', 
        'cols_per_block'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}