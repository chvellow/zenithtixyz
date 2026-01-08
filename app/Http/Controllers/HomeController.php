<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');

        // Mengambil semua data film dari database menggunakan Eloquent
        $movies = Movie::all(); 
        
        // Kirim data $movies ke view home.blade.php
        return view('index', compact('movies'));
    }
}
