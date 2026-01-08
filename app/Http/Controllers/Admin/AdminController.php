<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Movie;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
{
    // Statistik Dasar
    $filmCount = \App\Models\Movie::count();
    $scheduleCount = \App\Models\Schedule::count();
    $ordersCount = \App\Models\Order::count();
    $totalEarnings = \App\Models\Order::where('status', 'paid')->sum('total_price');

    // Data Grafik (7 Hari Terakhir)
    $chartData = \App\Models\Order::where('status', 'paid')
        ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('SUM(total_price) as total'))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->take(7)
        ->get();

    return view('admin.dashboard', compact('filmCount', 'scheduleCount', 'ordersCount', 'totalEarnings', 'chartData'));
}
    
}