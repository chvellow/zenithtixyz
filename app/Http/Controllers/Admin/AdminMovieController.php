<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
{
    $request->validate([
    'title'       => 'required|string|max:255',
    'description' => 'required',
    'genre'       => 'required',
    'duration'    => 'required|integer|min:1',
    'rating'      => 'required|numeric|min:0|max:10',
    'poster'      => 'required|image',
]);

    // Store poster
    $posterPath = $request->file('poster')->store('posters', 'public');

   Movie::create([
    'title'       => $request->title,
    'description' => $request->description,
    'genre'       => $request->genre,
    'duration'    => $request->duration,
    'rating'      => $request->rating,
    'poster'      => $posterPath,
]);



    return redirect()->route('admin.movies.index')
        ->with('success', 'Film berhasil ditambahkan!');
}


    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
{
   $request->validate([
    'title'       => 'required|string|max:255',
    'description' => 'required',
    'genre'       => 'required|string|max:100',
    'duration'    => 'required|integer|min:1',
    'rating'      => 'required|numeric|min:0|max:10',
    'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
]);


    $posterPath = $movie->poster;

    if ($request->hasFile('poster')) {
        Storage::disk('public')->delete($movie->poster);
        $posterPath = $request->poster->store('posters', 'public');
    }

   $movie->update([
    'title'       => $request->title,
    'description' => $request->description,
    'genre'       => $request->genre,
    'duration'    => $request->duration,
    'rating'      => $request->rating,
    'poster'      => $posterPath,
]);


    return redirect()->route('admin.movies.index')
        ->with('success', 'Film berhasil diperbarui!');
}


    public function destroy(Movie $movie)
    {
        Storage::disk('public')->delete($movie->poster);
        $movie->delete();

        return redirect()->route('admin.movies.index')
                         ->with('success', 'Film berhasil dihapus!');
    }
}
