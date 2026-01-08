<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Studio;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['movie', 'studio'])->orderBy('date')->orderBy('time')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $movies = Movie::all();
        $studios = Studio::all();
        return view('admin.schedules.create', compact('movies', 'studios'));
    }

   public function store(Request $request)
{
    $request->validate([
        'movie_id'  => 'required|exists:movies,id',
        'studio_id' => 'required|exists:studios,id',
        'date'      => 'required|date',
        'time'      => 'required',
        'price'     => 'required|numeric|min:0',
    ]);

    // Logic Tambahan (Opsional): Jika ingin memastikan harga benar-benar sesuai aturan server
    $data = $request->all();
    $day = date('w', strtotime($request->date));
    
    // Jika harga tidak diisi atau admin lupa, kita set otomatis
    if (!$request->filled('price')) {
        $data['price'] = ($day == 0 || $day == 6) ? 50000 : 35000;
    }

    Schedule::create($data);

    return redirect()->route('admin.schedules.index')->with('success', 'Jadwal ' . (($day == 0 || $day == 6) ? 'Weekend' : 'Weekdays') . ' Berhasil Dibuat!');
}

    public function edit(Schedule $schedule)
    {
        $movies = Movie::all();
        $studios = Studio::all();
        return view('admin.schedules.edit', compact('schedule', 'movies', 'studios'));
    }

    public function update(Request $request, Schedule $schedule)
{
    // Validasi memastikan studio_id ada di tabel studios
    $request->validate([
        'movie_id'  => 'required|exists:movies,id',
        'studio_id' => 'required|exists:studios,id',
        'date'      => 'required|date',
        'time'      => 'required',
        'price'     => 'required|numeric|min:0',
    ]);

    // Update data berdasarkan request yang sudah valid
    $schedule->update([
        'movie_id'  => $request->movie_id,
        'studio_id' => $request->studio_id,
        'date'      => $request->date,
        'time'      => $request->time,
        'price'     => $request->price,
    ]);

    return redirect()->route('admin.schedules.index')->with('success', 'Jadwal diperbarui!');
}

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal dihapus!');
    }
}