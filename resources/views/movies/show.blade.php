@extends('layouts.app')

@section('title', $movie->title)

@section('content')

<style>
    /* 1. CONTAINER UTAMA GLASSMORPHISM */
    .movie-detail-wrapper {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 35px;
        padding: 40px;
        margin-top: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    }

    /* 2. LAYOUT KIRI-KANAN (POSTER & INFO) */
    .detail-flex-container {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 40px;
    }

    .poster-side { flex: 0 0 280px; }
    .info-side { flex: 1; }

    .movie-poster {
        width: 100%;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .movie-info-title {
        font-weight: 900;
        font-size: 3rem;
        color: #d4af37; /* Emas ZenithTix */
        margin: 10px 0 15px;
        line-height: 1.1;
    }

    .genre-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(212, 175, 55, 0.1);
        color: #d4af37;
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .info-badge-card {
        background: rgba(255, 255, 255, 0.05);
        padding: 12px 20px;
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        min-width: 110px;
    }

    .info-badge-card small {
        display: block;
        color: #666;
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 800;
    }

    /* 3. JADWAL TAYANG PREMIUM CARD (Sesuai Gambar Referensi) */
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .schedule-card {
        background: #121212; /* Gelap pekat sesuai gambar */
        border-radius: 25px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .schedule-card:hover {
        transform: translateY(-10px);
        border-color: #d4af37;
    }

    .date-header {
        background: #2a2a2a; /* Warna header gelap elegan */
        padding: 12px;
        text-align: center;
        color: #d4af37;
        font-weight: 800;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }

    .schedule-body { padding: 25px; }

    .studio-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .type-badge {
        display: inline-block;
        background: white;
        color: black;
        padding: 2px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    /* AREA JAM TAYANG (HIGHLIGHT UTAMA) */
    .time-slot-box {
        background: #1d1d1d;
        border: 1px dashed rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        margin-bottom: 25px;
    }

    .time-val {
        font-size: 2.5rem;
        font-weight: 900;
        color: white;
        display: block;
        line-height: 1;
    }

    .price-val {
        font-size: 1.1rem;
        color: #888;
        font-weight: 600;
        margin-top: 8px;
        display: block;
    }

    .btn-pesan {
        display: block;
        width: 100%;
        padding: 16px;
        background: #d4af37; /* Kuning ZenithTix */
        color: black;
        border: none;
        border-radius: 20px;
        font-weight: 900;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-pesan:hover {
        background: #f1c40f;
        transform: scale(1.02);
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .detail-flex-container { flex-direction: column; align-items: center; text-align: center; }
        .poster-side { flex: 0 0 auto; width: 220px; }
        .movie-info-title { font-size: 2.2rem; }
    }
</style>

<div class="container py-5">
    <a href="/movies" style="text-decoration:none; color:#888; display:inline-flex; align-items:center; gap:8px; margin-bottom:25px;">
        <span class="material-symbols-outlined">arrow_back</span> Kembali ke Katalog
    </a>

    <div class="movie-detail-wrapper">
        <div class="detail-flex-container">
            <div class="poster-side">
                <img src="{{ asset('storage/' . $movie->poster) }}" class="movie-poster" alt="{{ $movie->title }}">
            </div>

            <div class="info-side">
                <span class="genre-badge">{{ $movie->genre }}</span>
                <h1 class="movie-info-title">{{ $movie->title }}</h1>
                <div class="movie-description">
                    <p>{{ $movie->description }}</p>
                </div>
                <div class="d-flex gap-3 mt-4">
                    <div class="info-badge-card">
                        <small>DURASI</small>
                        <span style="color:white; font-weight:700;">{{ $movie->duration }}</span>
                    </div>
                    <div class="info-badge-card">
                        <small>RATING</small>
                        <span style="color:#d4af37; font-weight:700;">{{ $movie->rating }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-5 mb-4 fw-bold" style="color: white; border-left: 5px solid #d4af37; padding-left: 15px; text-transform: uppercase; letter-spacing: 1px;">
        Jadwal Tayang
    </h3>

    <div class="schedule-grid">
        @forelse($movie->schedules as $schedule)
            <div class="schedule-card">
                <div class="date-header">
                    {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}
                </div>

                <div class="schedule-body">
                    <div class="studio-title">{{ $schedule->studios }}</div>
                    <span class="type-badge">{{ $schedule->studios_relation->type ?? 'Reguler' }}</span>
                    
                    <div class="time-slot-box">
                        <span class="time-val">{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</span>
                        <span class="price-val">Rp {{ number_format($schedule->price, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('booking.index', ['schedule_id' => $schedule->id]) }}" class="btn-pesan">
    PESAN TIKET
</a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666; background:rgba(255,255,255,0.02); border-radius:25px;">
                Belum ada jadwal tayang tersedia.
            </div>
        @endforelse
    </div>
</div>

@endsection