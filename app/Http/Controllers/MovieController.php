<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Akses untuk "/" -> resources/views/index.blade.php
    public function landing()
    {
        $movies = Movie::latest()->take(4)->get(); // Ambil 4 film saja untuk landing
        return view('index', compact('movies')); 
    }

    // Akses untuk "/movies" -> resources/views/movies/index.blade.php
   public function index(Request $request)
{
    $status = $request->query('status', 'now');
    $today = date('Y-m-d');
    $currentTime = date('H:i:s');

    // Ambil semua film yang punya jadwal hari ini dan belum selesai (jam >= sekarang)
    $moviesToday = Movie::whereHas('schedules', function($q) use ($today, $currentTime) {
        $q->where('date', $today)->where('time', '>=', $currentTime);
    })
    ->with(['schedules' => function($q) use ($today, $currentTime) {
        $q->where('date', $today)->where('time', '>=', $currentTime)->orderBy('time', 'asc');
    }])
    ->get()
    ->sortBy(function($movie) {
        return $movie->schedules->first()->time; // Urutkan berdasarkan jam tayang paling awal hari ini
    });

    if ($status == 'now') {
        // Ambil 1 film yang jam tayangnya paling dekat (paling atas di daftar)
        $movies = $moviesToday->take(1);
    } elseif ($status == 'next') {
        // Ambil semua film kecuali film pertama (daftar antrean jam berikutnya)
        $movies = $moviesToday->skip(1);
    } else {
        $movies = Movie::latest()->get(); // All Movies
    }

    return view('movies.index', compact('movies', 'status'));
}

    public function show($id)
    {
        $movie = Movie::with('schedules')->findOrFail($id);
        return view('movies.show', compact('movie'));
    }
}