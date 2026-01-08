<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order; // Sesuai tabel orders kamu
use Carbon\Carbon;

class CancelExpiredOrders extends Command
{
    // Nama perintah yang akan dijalankan
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Membatalkan order yang belum dibayar lebih dari 5 menit';

    public function handle()
    {
        // Cari order yang statusnya 'pending' dan dibuat lebih dari 5 menit yang lalu
        $expiredOrders = Order::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subMinutes(5))
            ->get();

        foreach ($expiredOrders as $order) {
            // Ubah status jadi cancelled
            $order->update(['status' => 'cancelled']);
            $this->info("Order ID {$order->id} telah dibatalkan karena melewati batas waktu.");
        }
    }
}