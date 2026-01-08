<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class AdminStudioController extends Controller
{
    public function index()
    {
        $studios = Studio::all();
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studios.create');
    }

    public function store(Request $request)
{
    // Sesuaikan dengan nama kolom di database: name, capacity, type
    $request->validate([
        'name'     => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'type'     => 'required|in:Reguler,VIP,Premiere,IMAX' //
    ]);

    // Menggunakan mass assignment atau manual agar aman
    Studio::create([
        'name'     => $request->name,
        'capacity' => $request->capacity,
        'type'     => $request->type
    ]);

    return redirect()->route('admin.studios.index')->with('success', 'Studio berjaya ditambah!');
}

public function update(Request $request, Studio $studio)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'type'     => 'required'
    ]);

    $studio->update($request->all());

    return redirect()->route('admin.studios.index')->with('success', 'Studio berjaya dikemaskini!');
}

    public function edit(Studio $studio)
    {
        return view('admin.studios.edit', compact('studio'));
    }

    

    public function destroy(Studio $studio)
    {
        $studio->delete();

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio berhasil dihapus!');
    }
}
