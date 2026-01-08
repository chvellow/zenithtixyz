<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $orders = Order::with(['user', 'schedule.movie', 'schedule.studio'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('schedule.movie', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

   public function create()
{
    // Ambil jadwal beserta orders yang sudah PAID
    $schedules = Schedule::with(['movie', 'studio', 'orders' => function($q) {
        $q->where('status', 'paid');
    }])->get();

    // Olah data kursi per jadwal agar bersih dari spasi
    $occupiedData = [];
    foreach ($schedules as $s) {
        $allSeats = $s->orders->pluck('seats')->flatMap(function($item) {
            // Pecah berdasarkan koma, lalu bersihkan spasi di tiap item
            return collect(explode(',', $item))->map(fn($seat) => trim($seat));
        })->unique()->values()->all();
        
        $occupiedData[$s->id] = implode(',', $allSeats);
    }

    return view('admin.orders.create', compact('schedules', 'occupiedData'));
}

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats'       => 'required|array', 
            'status'      => 'required|in:paid,pending'
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        $seatsString = implode(',', $request->seats);
        $totalPrice = count($request->seats) * $schedule->price;

        // Cek Double Booking: Pastikan kursi belum dipesan orang lain (Status Paid)
        $exists = Order::where('schedule_id', $request->schedule_id)
            ->where('status', 'paid')
            ->where(function($query) use ($request) {
                foreach($request->seats as $seat) {
                    $query->orWhere('seats', 'like', "%$seat%");
                }
            })->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Salah satu kursi sudah terisi!');
        }

        Order::create([
            'user_id'     => Auth::id(), 
            'movie_id'    => $schedule->movie_id, // Pastikan kolom ini ada di DB
            'schedule_id' => $schedule->id,
            'seats'       => $seatsString, 
            'total_price' => $totalPrice,
            'status'      => $request->status,
            'ticket_code' => 'ZNT-' . strtoupper(substr(uniqid(), 7))
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Booking Berhasil Disimpan!');
    }

    public function confirm($id)
    {
        Order::findOrFail($id)->update(['status' => 'paid']);
        return redirect()->back()->with('success', 'Booking telah dikonfirmasi!');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data booking dihapus!');
    }
}