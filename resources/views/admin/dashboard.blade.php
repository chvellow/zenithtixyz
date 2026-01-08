@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="main-content-wrapper px-3 px-md-4">
    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
        <div>
            <h1 class="dashboard-title">Dashboard Admin</h1>
            <p class="text-secondary m-0">Ringkasan performa sistem ZenithTix hari ini</p>
        </div>
        <div class="glass-card date-badge">
            <span class="text-white small fw-bold">
                <i class="fas fa-calendar-alt me-2 text-warning"></i> {{ date('d M Y') }}
            </span>
        </div>
    </div>

    {{-- Welcome Banner --}}
    <div class="dashboard-welcome glass-card mb-5 p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-extrabold text-white mb-3">Selamat datang kembali, Admin!</h2>
                <p class="m-0 text-secondary lh-lg">
                    Semua data transaksi, manajemen film, dan pengaturan jadwal studio dapat Anda kendalikan sepenuhnya melalui panel kontrol ini secara real-time.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <i class="fas fa-chart-line fa-5x text-white-50 opacity-25"></i>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid mb-5">
        <div class="stat-card glass-card">
            <div class="stat-content">
                <span class="stat-label">Total Pendapatan</span>
                <p class="stat-number text-success-glow">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</p>
            </div>
            <div class="icon-bg bg-success-soft"><i class="fas fa-money-bill-wave"></i></div>
        </div>

        <div class="stat-card glass-card">
            <div class="stat-content">
                <span class="stat-label">Koleksi Film</span>
                <p class="stat-number text-white">{{ $filmCount }}</p>
            </div>
            <div class="icon-bg bg-primary-soft"><i class="fas fa-film"></i></div>
        </div>

        <div class="stat-card glass-card">
            <div class="stat-content">
                <span class="stat-label">Jadwal Aktif</span>
                <p class="stat-number text-info-glow">{{ $scheduleCount }}</p>
            </div>
            <div class="icon-bg bg-info-soft"><i class="fas fa-calendar-check"></i></div>
        </div>

        <div class="stat-card glass-card">
            <div class="stat-content">
                <span class="stat-label">Total Pemesanan</span>
                <p class="stat-number text-warning-glow">{{ $ordersCount }}</p>
            </div>
            <div class="icon-bg bg-warning-soft"><i class="fas fa-ticket-alt"></i></div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="row pb-5">
        <div class="col-12">
            <div class="glass-card p-4 p-md-5 chart-container-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="accent-line"></div>
                        <h4 class="fw-bold m-0 text-white">Tren Pendapatan</h4>
                    </div>
                    <div class="badge-filter">7 Hari Terakhir</div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Dashboard Styles */
    .dashboard-title { color: #ffd43b; font-weight: 850; letter-spacing: -1px; margin: 0; }
    .fw-extrabold { font-weight: 800; }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    .date-badge { padding: 10px 20px; border-radius: 12px; }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .stat-card {
        padding: 25px;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover { transform: translateY(-5px); }

    .stat-label { 
        display: block; 
        text-transform: uppercase; 
        font-size: 11px; 
        font-weight: 700; 
        color: #888; 
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .stat-number { font-size: 26px; font-weight: 800; margin: 0; }

    /* Glow Colors */
    .text-success-glow { color: #2ecc71; text-shadow: 0 0 15px rgba(46, 204, 113, 0.3); }
    .text-info-glow { color: #3498db; text-shadow: 0 0 15px rgba(52, 152, 219, 0.3); }
    .text-warning-glow { color: #f1c40f; text-shadow: 0 0 15px rgba(241, 196, 15, 0.3); }

    .icon-bg {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .bg-success-soft { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .bg-primary-soft { background: rgba(255, 255, 255, 0.05); color: #fff; }
    .bg-info-soft { background: rgba(52, 152, 219, 0.1); color: #3498db; }
    .bg-warning-soft { background: rgba(241, 196, 15, 0.1); color: #f1c40f; }

    /* Chart Styles */
    .chart-container-card { border-radius: 24px; }
    .accent-line { width: 4px; height: 24px; background: #ffd43b; border-radius: 10px; }
    .badge-filter { background: rgba(0,0,0,0.3); color: #888; padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: 600; }
    .chart-wrapper { position: relative; height: 350px; width: 100%; }

    @media (max-width: 768px) {
        .stat-number { font-size: 22px; }
        .chart-wrapper { height: 250px; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create professional gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255, 212, 59, 0.2)'); 
    gradient.addColorStop(1, 'rgba(255, 212, 59, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($chartData->pluck('total')) !!},
                borderColor: '#ffd43b',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                borderWidth: 4,
                pointBackgroundColor: '#ffd43b',
                pointBorderColor: '#0a0a0a',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    padding: 15,
                    backgroundColor: '#1a1a1a',
                    titleColor: '#888',
                    bodyColor: '#fff',
                    bodyFont: { weight: 'bold', size: 14 },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.03)', drawBorder: false }, 
                    ticks: { 
                        color: '#555',
                        font: { size: 11 },
                        callback: value => 'Rp ' + value.toLocaleString('id-ID') 
                    } 
                },
                x: { 
                    grid: { display: false }, 
                    ticks: { color: '#555', font: { size: 11 } } 
                }
            }
        }
    });
</script>
@endsection