<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Studio;

class AdminSeatController extends Controller
{
    public function index()
    {
        $seats = Seat::with('studio')->orderBy('studio_id')->get();
        return view('admin.seats.index', compact('seats'));
    }

    public function create()
    {
        $studios = Studio::all();
        return view('admin.seats.create', compact('studios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'seat_code' => 'required|string|max:10',
            'type'      => 'required|string'
        ]);

        Seat::create($request->all());

        return redirect()->route('admin.seats.index')
            ->with('success', 'Kursi berhasil ditambahkan!');
    }

   public function editor(Studio $studio)
{
    // Ambil seat existing
    $seats = Seat::where('studio_id', $studio->id)->get()->keyBy('seat_code');

    // Buat array kursi berdasarkan rows & columns
    $grid = [];

    for ($r = 0; $r < $studio->rows; $r++) {
        $rowLetter = chr(65 + $r); // A, B, C...
        $grid[$rowLetter] = [];

        for ($c = 1; $c <= $studio->columns; $c++) {

            // tengah kosong buat jalan
            if ($c == ceil($studio->columns/2)) {
                $grid[$rowLetter][$c] = 'aisle';
                continue;
            }

            $seatCode = $rowLetter . $c;

            $grid[$rowLetter][$c] = $seats[$seatCode]->status ?? 'available';
        }
    }

    return view('admin.seats.editor', compact('studio', 'grid'));
}
public function save(Request $request, Studio $studio)
{
    $data = $request->input('seats'); // bentuknya array seat_code => status

    foreach ($data as $code => $status) {
        Seat::updateOrCreate(
            ['studio_id' => $studio->id, 'seat_code' => $code],
            ['status' => $status]
        );
    }

    return back()->with('success', 'Seat layout berhasil diperbarui!');
}


    public function update(Request $request, Seat $seat)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'seat_code' => 'required|string|max:10',
            'type'      => 'required|string'
        ]);

        $seat->update($request->all());

        return redirect()->route('admin.seats.index')
            ->with('success', 'Kursi berhasil diperbarui!');
    }

    public function destroy(Seat $seat)
    {
        $seat->delete();

        return redirect()->route('admin.seats.index')
            ->with('success', 'Kursi berhasil dihapus!');
    }
}
