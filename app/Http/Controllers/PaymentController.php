<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($id)
    {
        // Ambil data order beserta relasi schedule dan movie-nya
        $order = Order::with('schedule.movie')->findOrFail($id);
        return view('payment.index', compact('order'));
    }

    public function process($id)
    {
        $order = Order::findOrFail($id);
        // Ubah status jadi paid di database
        $order->update(['status' => 'paid']);

        return redirect()->route('orders.my_history')->with('success', 'Pembayaran Berhasil!');
    }
}