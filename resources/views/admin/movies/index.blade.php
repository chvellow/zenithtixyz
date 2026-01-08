@extends('admin.layouts.app')

@section('title', 'Kelola Film')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid p-0">
    {{-- Header Dashboard Style --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="color: #ffd43b; font-weight: 800; margin: 0;">Kelola Film</h2>
            <p class="text-secondary small">Daftar koleksi film yang tersedia di ZenithTix</p>
        </div>
        <a href="{{ route('admin.movies.create') }}" class="btn-add" style="background: #ffd43b; color: #000; padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none;">
            <i class="fas fa-plus me-2"></i> Tambah Film
        </a>
    </div>

    {{-- Tabel dengan Style Dashboard (Foto 2) --}}
    <div class="table-responsive">
        <table class="table align-middle m-0">
            <thead>
                <tr>
                    <th class="ps-4">Poster & Judul</th>
                    <th>Genre</th>
                    <th class="text-center">Rating</th>
                    <th>Durasi</th>
                    <th class="text-center pe-4" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="" style="width: 45px; height: 60px; object-fit: cover; border-radius: 6px; margin-right: 15px; border: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <div class="fw-bold text-white">{{ $movie->title }}</div>
                                <div class="text-secondary" style="font-size: 11px;">{{ $movie->release_date }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-secondary small">{{ $movie->genre }}</span></td>
                    <td class="text-center">
                        <div class="text-warning small">
                            <i class="fas fa-star me-1"></i>{{ $movie->rating }}
                        </div>
                    </td>
                    <td><div class="text-info small">{{ $movie->duration }} mnt</div></td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn-edit-icon">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('Hapus film?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete-icon">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<style>
    /* Styling Button Aksi agar selaras dengan Dashboard */
    .btn-edit-icon, .btn-delete-icon {
        width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: 0.3s; text-decoration: none; border: none;
    }
    .btn-edit-icon { background: rgba(58, 138, 247, 0.1); color: #3a8af7; }
    .btn-edit-icon:hover { background: #3a8af7; color: white; transform: translateY(-2px); }
    
    .btn-delete-icon { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .btn-delete-icon:hover { background: #e74c3c; color: white; transform: translateY(-2px); }
</style>
@endsection