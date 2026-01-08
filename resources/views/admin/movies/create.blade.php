@extends('admin.layouts.app')

@section('content')
<div class="main-content-wrapper">
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.movies.index') }}" class="btn-back-circle me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="admin-title m-0">Tambah Film Baru</h2>
    </div>

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" class="form-glass p-4">
        @csrf
        <div class="row">
            <div class="col-md-8 mb-3">
                <label>Judul Film</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul film">
            </div>
            <div class="col-md-4 mb-3">
                <label>Rating (0 - 10)</label>
                <input type="number" step="0.1" name="rating" value="{{ old('rating') }}" required placeholder="8.5">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Genre</label>
                <input type="text" name="genre" value="{{ old('genre') }}" required placeholder="Action, Horror, dll">
            </div>
            <div class="col-md-6 mb-3">
                <label>Durasi (Menit)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" required placeholder="120">
            </div>
        </div>

        <div class="mb-3">
            <label>Deskripsi / Sinopsis</label>
            <textarea name="description" rows="5" required placeholder="Tulis sinopsis film...">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label>Poster Film</label>
            <div class="upload-box">
                <input type="file" name="poster" accept="image/*" required id="posterInput">
                <p class="m-0 small text-secondary">Klik untuk unggah (JPG, PNG, WEBP - Max 2MB)</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn-submit">SIMPAN FILM</button>
            <a href="{{ route('admin.movies.index') }}" class="btn-cancel">BATAL</a>
        </div>
    </form>
</div>

<style>
    .form-glass { background: rgba(255, 255, 255, 0.02); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); }
    label { color: #d4af37; font-weight: 700; margin-bottom: 10px; display: block; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
    input, textarea { 
        width: 100%; background: rgba(0,0,0,0.2) !important; border: 1px solid rgba(255,255,255,0.1) !important; 
        color: white !important; padding: 12px; border-radius: 12px; margin-bottom: 10px; 
    }
    input:focus, textarea:focus { border-color: #ffd43b !important; outline: none; box-shadow: 0 0 10px rgba(255,212,59,0.1); }
    .upload-box { border: 2px dashed rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; text-align: center; }
    .btn-submit { background: linear-gradient(90deg, #d4af37, #b40000); border: none; color: white; padding: 12px 40px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: 0.3s; }
    .btn-submit:hover { transform: scale(1.02); filter: brightness(1.2); }
    .btn-cancel { background: rgba(255,255,255,0.05); color: white; padding: 12px 30px; border-radius: 12px; text-decoration: none; font-weight: 600; }
    .btn-back-circle { width: 40px; height: 40px; background: rgba(255,255,255,0.05); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; }
</style>
@endsection