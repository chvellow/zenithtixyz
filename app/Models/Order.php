<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'schedule_id',
        'seats',
        'total_price',
        'status',
        'ticket_code'
    ];

    // Relasi agar bisa dipanggil di Index Admin
    public function user() { return $this->belongsTo(User::class); }
    public function schedule() { return $this->belongsTo(Schedule::class); }
}