<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\Schedule;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $selectedScheduleId = $request->query('schedule_id');
        $selectedSchedule = Schedule::with(['movie', 'studio'])->find($selectedScheduleId);
        
        if (!$selectedSchedule || !$selectedSchedule->studio) {
            return redirect('/')->with('error', 'Jadwal atau Studio tidak ditemukan!');
        }

        $rows = $selectedSchedule->studio->total_rows; 
        $colsPerBlock = $selectedSchedule->studio->cols_per_block;

        // PERBAIKAN DI SINI: Mengambil kursi 'paid' dan membersihkan spasi
        $takenSeats = Order::where('schedule_id', $selectedScheduleId)
            ->where('status', 'paid') 
            ->get() // Ambil collection dulu
            ->flatMap(function($order) {
                // Hilangkan semua spasi, lalu pecah berdasarkan koma
                return explode(',', str_replace(' ', '', $order->seats));
            })
            ->unique()
            ->toArray();

        return view('booking.index', compact('selectedSchedule', 'takenSeats', 'rows', 'colsPerBlock'));
    }

    public function store(Request $request) {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|array|min:1',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        // KONSISTENSI: Simpan dengan format "A1, A2" agar seragam dengan data Admin
        $order = Order::create([
            'user_id'     => auth()->id(),
            'movie_id'    => $schedule->movie_id, 
            'schedule_id' => $schedule->id,
            'seats'       => implode(', ', $request->seats),
            'total_price' => count($request->seats) * $schedule->price,
            'status'      => 'pending',
            'ticket_code' => 'ZNT-' . strtoupper(substr(uniqid(), 7)) // Tambahkan ini biar tidak error di DB
        ]);

        return redirect()->route('payment.index', $order->id);
    }

    public function history() {
        $orders = Order::with(['schedule.movie', 'schedule.studio'])
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('history.index', compact('orders'));
    }
}