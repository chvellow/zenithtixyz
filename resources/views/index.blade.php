@extends('layouts.app')

@section('title', 'ZenithTix - Cinema Experience')

@section('content')
{{-- Bungkus utama agar bisa scroll dan tidak tertutup navbar --}}
<div class="homepage-wrapper">
    
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-7 hero-cta">
                    <h1 class="hero-title">Rasakan Film Dalam Skala Besar — Pesan Tiketmu di <span class="text-yellow">ZenithTix</span></h1>
                    <p class="lead text-secondary mb-4">UI bergaya bioskop modern: gelap, elegan, fokus pada poster. Pilih kursi, lihat showtimes, dan checkout cepat.</p>
                    <div class="cta-row d-flex gap-3">
                        <a href="#now" class="btn-zenith-primary">Cari Film</a>
                        <a href="#" class="btn-zenith-ghost">Tentang Kami</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                    <div class="featured-poster-frame">
                        <img src="{{ asset('storage/posters/dune2.jpg') }}" alt="Featured" class="img-fluid">
                        <div class="poster-glow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="now" class="catalog-section container py-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="accent-line"></div>
            <h2 class="section-title m-0">Now Showing</h2>
        </div>
        <a href="/movies" class="text-yellow text-decoration-none fw-bold small">LIHAT SEMUA <i class="fas fa-arrow-right ms-1"></i></a>
    </div>

    <div class="movie-grid">
        @forelse($movies as $movie)
            <div class="movie-card-custom">
                <div class="rating-badge">
                    <i class="fas fa-star me-1"></i> {{ $movie->rating ?? '8.5' }}
                </div>

                <div class="poster-wrapper">
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}">
                    
                    <a href="{{ url('/movies/' . $movie->id) }}" class="btn-detail-glass">
                        <i class="fas fa-ticket-alt me-2"></i> PESAN TIKET
                    </a>
                </div>

                <div class="movie-info-custom">
                    <div class="mb-2">
                        <span class="genre-pill">{{ $movie->genre }}</span>
                    </div>
                    
                    <h3 class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</h3>
                    
                    <div class="movie-meta">
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            {{ $movie->duration ?? '120' }} Menit
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-video"></i>
                            2D / IMAX
                        </div>
                    </div>

                    <div class="d-grid mt-3 d-md-none">
                        <a href="{{ url('/movies/' . $movie->id) }}" class="btn btn-warning btn-sm fw-bold">Detail</a>
                    </div>
                </div>
            </div>
        @empty  
            <div class="text-center w-100 py-5">
                <p class="text-secondary">Belum ada film yang tayang hari ini.</p>
            </div>
        @endforelse
    </div>
</section>
</div>

<style>
    /* Reset & Base */
    .homepage-wrapper {
        background-color: #0a0a0a;
        color: white;
        overflow-x: hidden;
        min-height: 100vh;
    }

    .text-yellow { color: #ffd43b; }

    /* Hero Section */
    .hero-section {
        background: radial-gradient(circle at top right, rgba(255, 212, 59, 0.05), transparent);
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .btn-zenith-primary {
        background: #ffd43b; color: #000; padding: 12px 30px; 
        border-radius: 12px; font-weight: 800; text-decoration: none; transition: 0.3s;
    }
    .btn-zenith-ghost {
        border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 12px 30px; 
        border-radius: 12px; font-weight: 600; text-decoration: none; transition: 0.3s;
    }
    .btn-zenith-primary:hover { background: #fff; transform: translateY(-3px); }

    /* Featured Poster */
    .featured-poster-frame {
        position: relative;
        width: 320px; height: 460px;
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transform: rotate(3deg);
    }
    .featured-poster-frame img { width: 100%; height: 100%; object-fit: cover; }

    /* Catalog Section */
    .accent-line { width: 50px; height: 4px; background: #ffd43b; border-radius: 2px; }
    .section-title { font-weight: 800; text-transform: uppercase; letter-spacing: 2px; }

    /* Movie Grid */
    .movie-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 30px;
    }

    .movie-card-custom {
        background: #141414;
        border-radius: 15px;
        overflow: hidden;
        transition: 0.4s;
        border: 1px solid rgba(255,255,255,0.03);
    }

    .movie-card-custom:hover {
        transform: translateY(-10px);
        border-color: rgba(255,212,59,0.3);
    }

    .poster-wrapper {
        position: relative;
        aspect-ratio: 2/3;
        overflow: hidden;
    }
    .poster-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .card-overlay {
        position: absolute; inset: 0;
        background: rgba(0,0,0,0.8);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: 0.3s;
    }
    .poster-wrapper:hover .card-overlay { opacity: 1; }

    .btn-detail {
        background: #fff; color: #000; padding: 8px 20px;
        border-radius: 8px; font-weight: 700; text-decoration: none;
    }

    .movie-info-custom { padding: 20px; }
    .movie-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .movie-genre { font-size: 0.85rem; color: #888; }
    .movie-rating { font-size: 0.85rem; font-weight: 600; }
</style>
@endsection